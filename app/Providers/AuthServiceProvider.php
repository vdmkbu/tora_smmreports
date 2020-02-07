<?php

namespace App\Providers;

use App\Project;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-panel', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('admin-project', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('update-project', function (User $user, Project $project) {
           if ($user->isAdmin()) {
               return true;
           }
           else {
               return $project->user_id == $user->id;
           }
        });

        Gate::define('view-project', function (User $user, Project $project) {
            if ($user->isAdmin()) {
                return true;
            }
            else {
                return $project->user_id == $user->id;
            }
        });

        Gate::define('delete-project', function (User $user, Project $project) {
            if ($user->isAdmin()) {
                return true;
            }
            else {
                return $project->user_id == $user->id;
            }
        });

        Gate::define('report-project', function (User $user, Project $project) {
            if ($user->isAdmin()) {
                return true;
            }
            else {
                return $project->user_id == $user->id;
            }
        });


    }
}
