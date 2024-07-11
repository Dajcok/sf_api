<?php

namespace tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;

abstract class TestCase extends BaseTestCase
{
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
