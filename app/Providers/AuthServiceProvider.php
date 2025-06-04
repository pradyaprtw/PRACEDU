<?php
namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy', // Uncomment dan sesuaikan jika Anda punya policy
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Di sini Anda bisa mendefinisikan Gate, dll.
        // Gate::define('edit-settings', function (User $user) {
        //     return $user->isAdmin;
        // });
    }
}
