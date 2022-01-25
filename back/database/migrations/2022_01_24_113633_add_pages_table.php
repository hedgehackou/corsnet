<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 1024)->nullable();;
            $table->string('slug');
            $table->unsignedBigInteger('sort');
            $table->boolean('is_deletable')->default(true);
        });

        Schema::create('header_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('title');
        });

        Schema::create('network_map_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->decimal('zoom')->nullable();
        });

        Schema::create('text_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('text')->nullable();
        });

        Schema::create('footer_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
        });

        Schema::create('page_blocks', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('block_id');
            $table->string('block_type');
            $table->unsignedBigInteger('sort');


            $table->foreign('page_id')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
