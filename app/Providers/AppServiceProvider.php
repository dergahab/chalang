<?php

namespace App\Providers;

use App\Helpers\CmsSidebar;
use App\Models\Contact;
use App\Models\Lang;
use App\Models\Service;
use App\Models\Socialmedia;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
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
        \Illuminate\Pagination\Paginator::useBootstrap();

        // Production hygiene: disable debug tooling and lower log verbosity in prod
        if ($this->app->environment('production')) {
            config([
                'debugbar.enabled' => false,
                'debugbar.storage.enabled' => false,
                'logging.channels.stack.level' => 'warning',
                'logging.channels.single.level' => 'warning',
                'logging.channels.daily.level' => 'warning',
            ]);
        }

        // Initialize and share sidebar items with all admin views
        view()->composer('admin.*', function () {
            $sidebar = CmsSidebar::getInstance();
            $sidebar->clearItems(); // Clear existing items
            $sidebar->addItems(config('cms_sidebar_menu')); // Add menu items
            view()->share('sidebarItems', $sidebar->getItems());
        });

        // Share other common data
        if (!$this->app->runningInConsole()) {
            if (Schema::hasTable('users')) {
                view()->share('users', User::all());
            }
            if (Schema::hasTable('langs')) {
                view()->share('languages', Lang::all());
                view()->share('langs', Lang::all());
            }
            if (Schema::hasTable('contacts')) {
                view()->share('contact', Contact::first());
            }
            if (Schema::hasTable('socialmedia')) {
                view()->share('socialmedia', Socialmedia::all());
            }
            if (Schema::hasTable('services')) {
                $services = Service::where('in_main', 1)
                    ->where('parent_id', 0)
                    ->get()
                    ->map(function ($service) {
                        $rawName = $service->name;
                        $flat = \Illuminate\Support\Arr::flatten((array) $rawName);
                        $service->name = implode(' / ', array_filter($flat, 'strlen'));
                        return $service;
                    });
                view()->share('main_services', $services);
            }
        }
    }
}
