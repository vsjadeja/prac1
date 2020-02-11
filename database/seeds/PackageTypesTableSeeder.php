<?php

use Illuminate\Database\Seeder;
use App\Models\PackageType;

class PackageTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackageType::create(['name' => 'Subject Pack', 'status' => true]);
        PackageType::create(['name' => 'Standard Pack', 'status' => true]);
    }
}
