<?php

namespace App\Providers;

use App\Services\AIService;
use App\Services\MockAIService;
use App\Services\OpenAIService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AIService::class, function ($app) {
            $provider = config('services.ai.provider', 'mock');

            if ($provider === 'openai' && config('services.openai.api_key')) {
                return new OpenAIService();
            }

            return new MockAIService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
