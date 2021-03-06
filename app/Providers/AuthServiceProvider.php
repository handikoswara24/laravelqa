<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Question;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class
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
        Passport::routes();
        //Passport::loadKeysFrom(__DIR__ . '/../secrets/oauth');

        // \Gate::define('update-question', function ($user, $question) {
        //     return $user->id == $question->user_id;
        // });

        // \Gate::define('delete-question', function ($user, $question) {
        //     return $user->id == $question->user_id;
        // });
    }
}
