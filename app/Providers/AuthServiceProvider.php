<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\User;
use App\Policies\LeadPolicy;
use App\Policies\CustomerSourcePolicy;
use App\Policies\SaleUserPolicy;
use App\Policies\ShowroomPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\UserPolicy;
use App\Policies\CustomerStatusPolicy;
use App\Policies\CustomerTypePolicy;
use App\Policies\RolePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PotentialPolicy;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    Lead::class => LeadPolicy::class,
    User::class => UserPolicy::class,
    CustomerSource::class => CustomerSourcePolicy::class,
    Showroom::class => ShowroomPolicy::class,
    CustomerStatus::class => CustomerStatusPolicy::class,
    Province::class => ProvincePolicy::class,
    SaleUser::class => SaleUserPolicy::class,
    CustomerType::class => CustomerTypePolicy::class,
    Role::class => RolePolicy::class,
    Permission::class => PermissionPolicy::class,
    Potential::class => PotentialPolicy::class,
    SupportChannel::class => SupportChannelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        
        // Register Gates
        Gate::define('manage-users', function (User $user) {
            return $user->hasPermission('users.manage');
        });

        Gate::define('manage-leads', function (User $user) {
            return $user->hasPermission('leads.manage');
        });
    }
}

