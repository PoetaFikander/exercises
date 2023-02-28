<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
//use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
        Gate::define('isActive', function (User $user){
            //dd($user->type_id);
            return $user->is_active;
        });

        Gate::define('isAdmin', function (User $user){
            return $user->type_id == 1;
        });

        Gate::define('isHPReports', function (User $user){
            return ($user->type_id == 1 || $user->type_id == 5);
        });


        //$this->defineUserRoleGate('isAdmin',1);
        //$this->defineUserRoleGate('isUser',2);
    }

    /*
    private function defineUserRoleGate($name, $role)
    {
        Gate::define($name, function (User $user) use ($role){
           return $user->type_id === $role;
        });
    }
    */
}
