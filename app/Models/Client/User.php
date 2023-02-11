<?php

namespace App\Models\Client;

use App\Enums\Client\GenderTypes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Uuid, HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'username',
        'city_id',
        'email',
        'img',
        'password',
        'gender',
        'birthday',
        'user_scope',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'link'
    ];

    protected $enumCasts = [
        'gender' => GenderTypes::class
    ];

    protected $dates = [
        'email_verified_at',
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(set: fn(string $password) => $this->attributes['password'] = Hash::make($password));
    }

    protected function link(): Attribute
    {
        return Attribute::make(get: fn() => isset($this->attributes['img']) && !empty($this->attributes['img']) ? config('app.url') . '/storage/uploads/' . $this->attributes['img'] : '');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function setExtendedName(): void
    {
        $name = $this->first_name . ' ' . $this->last_name;
        $this->name = $name;
    }

    public function generateNewUsername(string $name): string
    {
        $username = str_replace(' ', '_', $name);
        $count = $this->countSameUsername($username) + 1;
        $username .= "_$count";
        return $username;
    }

    private function countSameUsername(string $username): int
    {
        return $this->where('username', 'like', $username . '\_%')->count();
    }

    public function login(array $userData, ?User $user = null): ?self
    {
        if ($user && Hash::check($userData['password'], $user->password)) {
            $user->bearer_token = $user->createToken('tourist', [$user->user_scope])->accessToken;
            return $user;
        }
        return null;
    }

    public function register(array $userData): ?self
    {
        $userData['user_scope'] = 'user';
        $userData['name'] = $userData['first_name'] . ' ' . $userData['last_name'];
        $userData['username'] = $this->generateNewUsername($userData['name']);
        $user = self::create($userData);
        return $this->login($userData, $user);
    }
}
