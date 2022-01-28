<?php

namespace App\Providers;

use App\Models\User;
use App\Modules\Settings\Models\FooterBlock;
use App\Modules\Settings\Models\HeaderBlock;
use App\Modules\Settings\Models\NetworkMapBlock;
use App\Modules\Settings\Models\TextBlock;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'header' => HeaderBlock::class,
            'text' => TextBlock::class,
            'footer' => FooterBlock::class,
            'google-map' => NetworkMapBlock::class,
            'user' => User::class,
        ]);
    }
}
