<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Laboratory;
use App\Models\User;
use App\Models\Visit;
use App\Models\Visitor;
use App\Policies\LaboratoryPolicy;
use App\Policies\UserPolicy;
use App\Policies\VisitorPolicy;
use App\Policies\VisitPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Laboratory::class => LaboratoryPolicy::class,
        User::class => UserPolicy::class,
        Visit::class => VisitPolicy::class,
        Visitor::class => VisitorPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
