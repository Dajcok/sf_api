<?php

namespace Tests\Unit\Services;

use app\Contracts\Services\AuthServiceContract;
use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\Unauthorized;
use App\Services\AuthService;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use Tests\Mocks\External\JWTAuthMock;
use Tests\Mocks\External\RedisMock;
use Tests\Mocks\Repositories\UserRepositoryMock;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthServiceContract $service;

    public function setUp(): void
    {
        parent::setUp();

        JWTAuthMock::create();
        RedisMock::create();

        $this->service = new AuthService(UserRepositoryMock::create());
    }

    /**
     * @throws QueryException
     */
    #[Group('auth')]
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
     */
    #[Group('auth')]
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
     */
    #[Group('auth')]
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
     */
    #[Group('auth')]
    public function testInvalidLogin(): void
    {
        $this->expectException(TokenInvalidException::class);

        $payload = new UserLoginInputData(email: 'invalid@example.com', password: 'invalidpassword');
        $this->service->login($payload);
    }

    /**
     * @throws Unauthorized
     */
    #[Group('auth')]
    public function testInvalidRefreshToken(): void
    {
        $this->expectException(TokenInvalidException::class);

        $payload = new RefreshTokenInputData(refreshToken: 'invalidtoken');
        $this->service->refreshToken($payload);
    }

    public function testCreateCustomer(): void
    {
        $result = $this->service->createCustomer();

        $this->assertInstanceOf(AuthenticatedOutputData::class, $result);
        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEmpty($result->refreshToken);
    }
}
