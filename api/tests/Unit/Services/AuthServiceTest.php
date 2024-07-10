<?php

namespace Tests\Unit\Services;

use app\Contracts\Services\AuthServiceContract;
use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\Unauthorized;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\UserService;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\External\JWTAuthMock;
use Tests\Mocks\External\RedisMock;
use Tests\Mocks\Models\UserModelMock;
use Tests\Mocks\Repositories\UserRepositoryMock;
use tests\TestCase;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthServiceContract $service;

    /**
     * @throws QueryException
     */
    public function setUp(): void
    {
        parent::setUp();

        JWTAuthMock::create();
        RedisMock::create();

        $userService = new UserService(UserRepositoryMock::create());
        $this->service = new AuthService($userService);
    }

    /**
     * @throws QueryException
     * @group auth
     */
    public function testRegister(): void
    {
        $payload = new UserCreateInputData(name: 'John Doe', email: 'john@doe2.com', password: 'StrongPWD');

        $result = $this->service->register($payload);

        $this->assertInstanceOf(AuthenticatedOutputData::class, $result);
        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEmpty($result->refreshToken);
    }

    /**
     * @throws Unauthorized
     * @group auth
     */
    public function testLogin(): void
    {
        $payload = new UserLoginInputData(email: 'john@doe2.com', password: 'StrongPWD');
        $result = $this->service->login($payload);

        $this->assertInstanceOf(AuthenticatedOutputData::class, $result);
        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEmpty($result->refreshToken);
    }

    /**
     * @throws Unauthorized
     * @group auth
     */
    public function testRefreshToken(): void
    {
        $payload = new UserLoginInputData(email: 'john@doe2.com', password: 'StrongPWD');
        $loginResult = $this->service->login($payload);

        $refreshPayload = new RefreshTokenInputData(refreshToken: $loginResult->refreshToken);
        $result = $this->service->refreshToken($refreshPayload);

        $this->assertInstanceOf(AuthenticatedOutputData::class, $result);
        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEmpty($result->refreshToken);
    }

    /**
     * @throws Unauthorized
     * @group auth
     */
    public function testInvalidLogin(): void
    {
        $this->expectException(TokenInvalidException::class);

        $payload = new UserLoginInputData(email: 'invalid@example.com', password: 'invalidpassword');
        $this->service->login($payload);
    }

    /**
     * @throws Unauthorized
     * @group auth
     */
    public function testInvalidRefreshToken(): void
    {
        $this->expectException(TokenInvalidException::class);

        $payload = new RefreshTokenInputData(refreshToken: 'invalidtoken');
        $this->service->refreshToken($payload);
    }
}
