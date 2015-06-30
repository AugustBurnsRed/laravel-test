<?php

namespace App\Providers;

use App\Torrent;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeNavigation();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Compose the navigation bar.
     *   
     */
    private function composeNavigation()
    {     
        //pour du code plus long, utiliser un forder http\composers\...   
        //view()->composer('partials.navbar', 'App\Http\Composers\NavigationComposer@compose');

        view()->composer('partials.navbar', function($view)
        {
            $view->with('latest', Torrent::latest()->first());
        });
    }
}
