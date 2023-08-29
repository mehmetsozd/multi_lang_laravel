<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(!session()->get('locale')){
            session()->put('locale', env('APP_DEFUALT_LANG'));
        }

        try {
            $translate = \App\Models\Translate::where('code', session()->get('locale'))->first();
            view()->composer('*',function($view) use ($translate) {
                $view->with('translates', $translate->translate);
            });
        } catch (\Exception $e) {
            view()->composer('*',function($view)  {
                $view->with('translates', []);
            });
        }

    }
}
