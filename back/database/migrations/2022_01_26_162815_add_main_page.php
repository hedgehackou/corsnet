<?php

use App\Modules\Settings\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddMainPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('header_blocks', function (Blueprint $table) {
            $table->boolean('is_deletable')->default(true);
        });
        Schema::table('footer_blocks', function (Blueprint $table) {
            $table->boolean('is_deletable')->default(true);
        });
        Schema::disableForeignKeyConstraints();
        Artisan::call('db:seed');
        Schema::enableForeignKeyConstraints();
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
