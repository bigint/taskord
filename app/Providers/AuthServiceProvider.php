<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
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

        Gate::define('staff.ops', function (User $user) {
            return $user->is_staff and $user->staff_mode;
        });

        Gate::define('user.follow', function (User $sourceUser, User $targetUser) {
            return $this->cannotPerformOnEntity($sourceUser, $targetUser);
        });

        Gate::define('task.check', function (User $user, Task $task) {
            return $this->canPerformOnEntity($user, $task->user);
        });

        Gate::define('create', function (User $user) {
            return $this->canPerform($user);
        });

        Gate::define('like/subscribe', function (User $user, $entity) {
            return $this->cannotPerformOnEntity($user, $entity->user);
        });

        Gate::define('edit/delete', function (User $user, $entity) {
            return $this->canPerformOnEntity($user, $entity->user);
        });
    }

    public function cannotPerformOnEntity(User $currentUser, User $entityUser)
    {
        if (
            $currentUser->spammy or
            ! $currentUser->hasVerifiedEmail() or
            $currentUser->id === $entityUser->id
        ) {
            return false;
        }

        return true;
    }

    public function canPerformOnEntity(User $user, User $entityUser)
    {
        if ($user->spammy) {
            return false;
        }

        if ($user->staff_mode or $user->id === $entityUser->id) {
            return true;
        }

        return false;
    }

    public function canPerform(User $user)
    {
        if (
            $user->spammy or
            ! $user->hasVerifiedEmail()
        ) {
            return false;
        }

        return true;
    }
}
