<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->boolean('status')->nullable()->default(true);
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->text('description');
            $table->float('price');
            $table->string('thumb', 100)->nullable()->default('default.jpg');
            $table->bigInteger('package_type_id')->unsigned();
            $table->boolean('status')->nullable()->default(true);
            $table->timestamps();

            $table->foreign('package_type_id')
                ->references('id')
                ->on('package_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_types');
        Schema::dropIfExists('packages');
    }
}
