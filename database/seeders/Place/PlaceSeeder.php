<?php

namespace Database\Seeders\Place;

use App\Models\Client\User;
use App\Models\Place\Place;
use App\Models\Place\PlaceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Place::all()->each(function ($place) {
            $place->clearMediaCollection();
        });
        DB::table('places')->truncate();
        $admin = User::select(['id'])->where('user_scope', '=', 'admin')->first();
        $type[] = PlaceType::select(['id'])->where('name', '=', 'أماكن أثرية')->first();
        $type[] = PlaceType::select(['id'])->where('name', '=', 'مطاعم')->first();
        $type[] = PlaceType::select(['id'])->where('name', '=', 'فنادق')->first();
        $places = [
            [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $admin->id,
                'place_type_id' => $type[0]->id,
                'name' => 'قلعة حلب',
                'images' => ['aleppo-citadel-1.jpg', 'aleppo-citadel-2.jpg', 'aleppo-citadel-3.jpg'],
                'description' => 'قلعة حلب قصر محصن يعود إلى العصور الوسطى. تعتبر قلعة حلب إحدى أقدم وأكبر القلاع في العالم، يعود استخدام التل الذي تتوضع عليه القلعة إلى الألفية الثالثة قبل الميلاد، حيث احتلتها فيما بعد العديد من الحضارات بما في ذلك الإغريق والبيزنطيين والمماليك والأيوبيين، بينما يظهر أن أغلب البناء الحالي يعود إلى الفترة الأيوبية',
                'price' => 0,
                'started_at' => null,
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $admin->id,
                'place_type_id' => $type[0]->id,
                'name' => 'قلعة سمعان',
                'images' => ['simeons-castle-1.jpg', 'simeons-castle-2.jpg', 'simeons-castle-3.jpg'],
                'description' => 'دير سمعان أو دير ثلانيسوس هو دير في سوريا بالقرب من مدينة حلب السورية تقع قلعة سمعان فوق نتوء صخري في جبل سمعان يرتفع نحو 564م عن سطح البحر.',
                'price' => 0,
                'started_at' => null,
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $admin->id,
                'place_type_id' => $type[0]->id,
                'name' => 'جامع الأموي الكبير',
                'images' => ['great-umayyad-mosque-1.jpg_large', 'great-umayyad-mosque-2.jpg_large'],
                'description' => 'جَامِعُ حَلَب الكَبير أو الجامع الأموي في حلب أو جامع بني أمية الكبير في حلب هو أحد أكبر وأقدم المساجد في مدينة حلب السورية، حيث يقع المسجد في حي الجلوم في المدينة القديمة من حلب، التي أدرجت على قائمة مواقع التراث العالمي عام 1986، حيث أصبح الجامع جزءاً من التراث العالمي، وهو يقع بالقرب من سوق المدينة.',
                'price' => 0,
                'started_at' => null,
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $admin->id,
                'place_type_id' => $type[1]->id,
                'name' => 'مطعم بيرويا',
                'images' => ['beroia-restaurant-1.jpg', 'beroia-restaurant-2.jpg', 'beroia-restaurant-3.jpg'],
                'description' => 'مكان رائع مع منظر جميل وطعام لذيذ هذا المكان مشهور جداً في مدينة حلب خاصة أنه يقع في هارت مدينة حلب القديمة ، أسفل القلعة يقدمون الطعام السوري ، وخاصة أطباق الحلابية ، بالإضافة إلى الوجبات الغربية',
                'price' => 0,
                'started_at' => null,
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $admin->id,
                'place_type_id' => $type[1]->id,
                'images' => ['alquma-restaurant-1.jpg', 'alquma-restaurant-2.jpg', 'alquma-restaurant-3.jpg'],
                'name' => 'مطعم القمة',
                'description' => '‪ميعكس مطعم القمة بتصميماته الداخلية الكلاسيكية وديكوراته الثقافة الشعبية السائدة في سوريا. ويحوي مقاعد عربية عليها نقوش شرقية مميزة. كما يقدم مجموعةً من الأطباق المحضرة حسب الوصفات التي توارثتها الأجيال. بالإضافة إلى ذلك، يقدم مطابخه المتنوعة بطريقة عصرية وجذابة. تشمل المأكولات الكباب، والشيش طاووق، والسمك مشوي على الفحم، والكبة. بالإضافة إلى ذلك باذنجان مشوي يقدم مع لحم بقري وخضار وبهارات وغيره',
                'price' => 0,
                'started_at' => null,
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $admin->id,
                'place_type_id' => $type[2]->id,
                'images' => ['sheraton-hotel-1.jpg', 'sheraton-hotel-2.jpg', 'sheraton-hotel-3.jpg'],
                'name' => 'فندق شيرتون',
                'description' => 'فندق شيراتون حلب أو شيراتون باب الفرج هو فندق 5 نجوم افتتح عام 2007 في مدينة حلب القديمة، ضمن السور التاريخي للمدينة، على شارع الخندق، في منطقة العقبة بالقرب من ساعة باب الفرج.',
                'price' => 0,
                'started_at' => null,
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'user_id' => $admin->id,
                'place_type_id' => $type[2]->id,
                'name' => 'فندق البارون',
                'images' => ['baron-hotel-1.jpg', 'baron-hotel-2.jpg'],
                'description' => ' هو فندق تاريخي عريق في مدينة حلب في سورية، قرب متحف حلب الوطني. يزيد عمره عن قرن من الزمان.',
                'price' => 0,
                'started_at' => null,
                'ended_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($places as $place) {
            $images = $place['images'] ?? [];
            unset($place['images']);
            $placeObject = (new Place())->create($place);
           foreach ($images as $image) {
               $image = storage_path('images/places/'  . $image);
               $placeObject->copyMedia($image)->toMediaCollection();
           }
        }
    }
}
