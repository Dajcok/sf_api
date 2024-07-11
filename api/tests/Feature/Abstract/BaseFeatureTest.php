<?php

namespace tests\Feature\Abstract;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use tests\TestCase;

class BaseFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifies the environment configuration so we won't run tests on the wrong environment.
     *
     * @return void
     */
    public function testEnvironmentConfiguration(): void
    {
        $this->assertEquals('testing', env('APP_ENV'));
        $this->assertEquals(2, env('REDIS_DB'));
        $this->assertEquals(3, env('REDIS_CACHE_DB'));
    }

    /**
     * Returns authenticated instance of TestCase
     *
     * @return BaseFeatureTest
     */
    public function asUser(?User $user = null): BaseFeatureTest
    {
        if (!$user) {
            $user = User::factory()->create([
                'password' => 'password123',
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return $this->withHeaders([
            'Authorization' => "Bearer $token",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }
}
