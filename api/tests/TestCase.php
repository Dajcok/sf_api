<?php

namespace tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{
    /**
     * @test
     * @group feature
     *
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
     * This assertion is crucial to verify consistency of the structure of all successfull API responses.
     *
     * @param TestResponse $response
     * @param int          $status
     * @param array        $data
     * @return TestResponse
     */
    protected function assertSuccessfullApiJsonStructure(TestResponse $response, int $status, array $data = []): TestResponse
    {
        $response->assertStatus($status)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => $data,
            ]);

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
    protected function assertUnsuccessfullApiJsonStructure(TestResponse $response, int $status, array $errors = []): TestResponse
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
     * @throws \ReflectionException
     */
    protected function isUnitTest(): bool
    {
        $reflection = new ReflectionClass($this);
        $method = $reflection->getMethod($this->getName(false));
        $docComment = $method->getDocComment();

        return strpos($docComment, '@group unit') !== false;
    }

}
