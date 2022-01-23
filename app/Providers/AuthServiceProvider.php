<?php

namespace App\Providers;

use App\Policies\LabelPolicy;
use App\Policies\TaskStatusPolicy;
use App\Policies\TaskPolicy;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\Label;
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
        TaskStatus::class => TaskStatusPolicy::class,
        Task::class => TaskPolicy::class,
        Label::class => LabelPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
