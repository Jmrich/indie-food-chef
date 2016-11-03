<?php

namespace App\Providers;

use App\Chef;
use App\Customer;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'customer' => Customer::class,
            'chef' => Chef::class,
        ]);

        /*\DB::listen(function ($query) {
             var_dump($query->sql);
             var_dump($query->bindings);
             $query->time;
        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
    }
}
