<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Settings\Models\FooterBlock;
use App\Modules\Settings\Models\HeaderBlock;
use App\Modules\Settings\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Page::query()->truncate();
        DB::table('page_blocks')->truncate();
        HeaderBlock::query()->truncate();
        FooterBlock::query()->truncate();
        /** @var Page $page */
        $page = Page::query()->create([
            'title' => __('common.main_page'),
            'description' => '',
            'slug' => '',
            'sort' => 0,
            'is_deletable' => false
        ]);
        $header = HeaderBlock::create([
            'title' => "",
            'logo' => '',
            'is_deletable' => false,
        ]);
        $footer = FooterBlock::create([
            'address' => "",
            'phone' => '',
            'email' => '',
            'is_deletable' => false,
        ]);

        $page->headerBlocks()->attach($header, ['sort' => 0]);
        $page->footerBlocks()->attach($footer, ['sort' => 99999]);

        Schema::enableForeignKeyConstraints();
    }
}
