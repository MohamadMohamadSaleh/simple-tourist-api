<?php

namespace Database\Seeders\Product;

use App\Models\Place\Place;
use App\Models\Product\Product;
use App\Models\Product\ProductType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::all()->each(function ($product) {
            $product->clearMediaCollection();
        });
        DB::table('products')->truncate();
        $products = [
            [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => Place::query()->select('id')->where('name', 'مطعم بيرويا')->first()->id,
                'product_type_id' => ProductType::query()->where('name', 'الإفطار')->first()->id,
                'name' => 'شوربة دجاج',
                'price' => 5000,
                'img' => 'chicken-soup.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => Place::query()->select('id')->where('name', 'مطعم بيرويا')->first()->id,
                'product_type_id' => ProductType::query()->where('name', 'مأكولات شرقية')->first()->id,
                'name' => 'المنسف',
                'price' => 25000,
                'img' => 'mansaf.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => Place::query()->select('id')->where('name', 'مطعم القمة')->first()->id,
                'product_type_id' => ProductType::query()->where('name', 'مشروبات')->first()->id,
                'name' => 'عصير برتقال طبيعي',
                'img' => 'orange-juice.jpg',
                'price' => 1000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => Place::query()->select('id')->where('name', 'مطعم القمة')->first()->id,
                'product_type_id' => ProductType::query()->where('name', 'مأكولات شرقية')->first()->id,
                'name' => 'كبة مقلية',
                'price' => 30000,
                'img' => 'fried-kibbeh.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => Place::query()->select('id')->where('name', 'مطعم القمة')->first()->id,
                'product_type_id' => ProductType::query()->where('name', 'مأكولات غربية')->first()->id,
                'name' => 'اليالنجي',
                'price' => 20000,
                'img' => 'yalanji.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::orderedUuid()->toString(),
                'place_id' => Place::query()->select('id')->where('name', 'مطعم القمة')->first()->id,
                'product_type_id' => ProductType::query()->where('name', 'حلويات')->first()->id,
                'name' => 'بقلاوة',
                'img' => 'baklava.jpg',
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($products as $product) {
            $img = storage_path('images/products/' . $product['img']);
            unset($product['img']);
            $productObject = (new Product())->create($product);
            $productObject->copyMedia($img)->toMediaCollection();
        }
    }
}
