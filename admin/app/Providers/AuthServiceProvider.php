<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\UserPolicy;
use App\Policies\GroupsPolicy;
use App\Models\Modules;
use App\Models\User;
use App\Models\Groups;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Groups::class => GroupsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*
            users.view
            1. Get lists modules
        */

        $modulesList = Modules::all();

        if ($modulesList->count() > 0) {
            foreach ($modulesList as $module) {
                Gate::define($module->name, function(User $user) use ($module) {
                    $roleJson = $user->group->permissions;
                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name);
                        return $check;
                    }

                    return false;
                });

                Gate::define($module->name.'.add', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;

                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'add');
                        return $check;
                    }
                    return false;
                });

                Gate::define($module->name.'.edit', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;

                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'edit');
                        return $check;
                    }
                    return false;
                });

                Gate::define($module->name.'.delete', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;

                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'delete');
                        return $check;
                    }
                    return false;
                });

                Gate::define($module->name.'.permission', function (User $user) use ($module) {
                    $roleJson = $user->group->permissions;

                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'permission');
                        return $check;
                    }
                    return false;
                });
            }
        }

    }
}
