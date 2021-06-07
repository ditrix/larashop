<?php

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // создать 4 бренда
       factory(App\Models\Brand::class, 5)->create();  
    }
}
