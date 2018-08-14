<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();
        DB::table('products_categories')->delete();
        DB::table('products_images')->delete();

        $rss = new \DOMDocument();
        $rss->load('database/data/alapaine.xml');
        $nodes = $rss->getElementsByTagName('item');

        foreach ($nodes as $node) {
            Laravel\Product::create(array(
                'unique_identifier' => $node->getElementsByTagName('id')->item(0)->nodeValue,
                'category'          => $node->getElementsByTagName('product_type')->item(0)->nodeValue,
                'name'              => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'description'       => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'price'             => $node->getElementsByTagName('price')->item(0)->nodeValue,
                'image'             => $node->getElementsByTagName('image_link')->item(0)->nodeValue
            ));

            Laravel\Category::create(array(
                'product_id'                => $node->getElementsByTagName('id')->item(0)->nodeValue,
                'product_category'          => $node->getElementsByTagName('product_type')->item(0)->nodeValue,
            ));

            
            Laravel\Image::create(array(
                'product_id'                => $node->getElementsByTagName('id')->item(0)->nodeValue,
                'image_link'                => $node->getElementsByTagName('additional_image_link')->item(0)->nodeValue,
                'image_alt'                => $node->getElementsByTagName('title')->item(0)->nodeValue,
            ));
            
        }


        /*$rss = new \DOMDocument();
        $rss->load(public_path().'/alapaine.xml');
        $nodes = $rss->getElementsByTagName('item');
        foreach ($nodes as $node) {
            $title[] = $node->getElementsByTagName('title')->item(0)->nodeValue;
            $description[] = $node->getElementsByTagName('description')->item(0)->nodeValue;
            $product_type[] = $node->getElementsByTagName('product_type')->item(0)->nodeValue;
            $link[] = $node->getElementsByTagName('link')->item(0)->nodeValue;
        }
*/

        /*factory(App\Product::class, 50)->create()->each(function($p) {
        	$p->save();
        });*/
    }
}
