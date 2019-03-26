<?php

namespace App\Providers;

use App\Models\Candidate;
use App\Models\Department;
use App\Models\Interview;
use App\Models\Job;
use App\Models\Offer;
use App\Policies\CandidatePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\InterviewPolicy;
use App\Policies\JobPolicy;
use App\Policies\OfferPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Candidate::class => CandidatePolicy::class,
        Interview::class => InterviewPolicy::class,
        Offer::class => OfferPolicy::class,
        Job::class => JobPolicy::class,
        User::class => UserPolicy::class,
        Department::class => DepartmentPolicy::class
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
    }
}
