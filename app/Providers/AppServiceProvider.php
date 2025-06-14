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
        // Share sidebar items with all admin views
        view()->composer('admin.*', function () {
            $this->generateCmsSidebar();
            view()->share('sidebarItems', CmsSidebar::getInstance()->getItems());
        });

        if (Schema::hasTable('users')) {
            view()->share('users', User::all());
        }
        if (Schema::hasTable('langs')) {
            view()->share('languages', Lang::all());
        }
        if (Schema::hasTable('langs')) {
            view()->share('langs', Lang::all());
        }
        if (Schema::hasTable('contacts')) {
            view()->share('contact', Contact::first());
        }
        if (Schema::hasTable('socialmedia')) {
            view()->share('socialmedia', Socialmedia::all());
        }
        if (Schema::hasTable('services')) {
            view()->share('main_services', Service::where('in_main', 1)->where('parent_id', 0)->get());
        }
    }

    public function generateCmsSidebar()
    {
        $adminSidebarMenu = CmsSidebar::getInstance();
        $adminSidebarMenu->addItems(config('cms_sidebar_menu'));
    }
}