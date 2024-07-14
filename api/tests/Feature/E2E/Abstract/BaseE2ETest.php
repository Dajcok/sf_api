<?php

namespace tests\Feature\E2E\Abstract;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BaseE2ETest extends TestCase
{
    use RefreshDatabase;


    /**
     * This assertion is crucial to verify consistency of the structure of all successfull API responses.
     *
     * @param TestResponse $response
     * @param int          $status
     * @param array        $data
     * @return TestResponse
     */
    protected function assertSuccessfullApiJsonStructure(TestResponse $response, array $data = [], int $status = Response::HTTP_OK): TestResponse
    {
        $response->assertStatus($status)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => $data,
            ]);

        return $response;
    }

    protected function assertSuccessfullApiJsonStructureOnIndex(TestResponse $response): TestResponse
    {
        $this->assertSuccessfullApiJsonStructure($response, ['items', 'links']);
        return $response;
    }

    /**
     * This assertion is crucial to verify consistency of the structure of all unsuccessfull API responses.
     *
     * @param TestResponse $response
     * @param int          $status
     * @param array        $errors
     * @return TestResponse
     */
    protected function assertUnsuccessfullApiJsonStructure(TestResponse $response, array $errors = [], int $status = Response::HTTP_UNPROCESSABLE_ENTITY): TestResponse
    {
        $response->assertStatus($status)
            ->assertJsonStructure([
                'status',
                'message',
                'errors' => $errors,
            ]);

        return $response;
    }

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
     * @param User|null $user
     * @return BaseE2ETest
     */
    public function asUser(?User $user = null): BaseE2ETest
    {
        if (!$user) {
            $user = User::factory()->create([
                'password' => 'password123',
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return $this->withRequiredHeaders()->withHeaders([
            'Authorization' => "Bearer $token",
        ]);
    }

    /**
     * Returns instance of TestCase with required headers
     *
     * @return BaseE2ETest
     */
    public function withRequiredHeaders(): BaseE2ETest
    {
        return $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }
}
