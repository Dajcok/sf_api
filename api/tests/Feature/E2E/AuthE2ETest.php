<?php

namespace tests\Feature\E2E;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use tests\Feature\E2E\Abstract\BaseE2ETest;

class AuthE2ETest extends BaseE2ETest
{
    public function testRegisterInvalidEmail(): void
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson(route('api.auth.register'), $payload);

        $this->assertUnsuccessfullApiJsonStructure($response, errors: [
            'email',
        ]);
    }

    public function testRegisterPasswordMismatch(): void
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password1234',
        ];

        $response = $this->postJson(route('api.auth.register'), $payload);

        $this->assertUnsuccessfullApiJsonStructure($response, errors: [
            'password',
        ]);
    }

    public function testRegisterPasswordTooShort(): void
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ];

        $response = $this->postJson(route('api.auth.register'), $payload);

        $this->assertUnsuccessfullApiJsonStructure($response, errors: [
            'password',
        ]);
    }

    public function testRegister(): void
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson(route('api.auth.register'), $payload);

        $this->assertSuccessfullApiJsonStructure($response, [
            'access_token',
            'refresh_token',
        ], SymfonyResponse::HTTP_CREATED);
        $this->assertNotNull($response->json('data.access_token'));
        $this->assertNotNull($response->json('data.refresh_token'));
    }

    public function testRegisterExistingEmail(): void
    {
        User::factory()->create([
            'email' => 'existing@email.com',
            'password' => 'password123',
        ]);

        $payload = [
            'name' => 'Test User',
            'email' => 'existing@email.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson(route('api.auth.register'), $payload);

        $this->assertUnsuccessfullApiJsonStructure($response, errors: [
            'email',
        ]);
    }

    public function testLogin(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $payload = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson(route('api.auth.login'), $payload);

        $this->assertSuccessfullApiJsonStructure($response, [
            'access_token',
            'refresh_token',
        ]);
        $this->assertNotNull($response->json('data.access_token'));
        $this->assertNotNull($response->json('data.refresh_token'));
    }

    public function testRefreshToken(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $loginRes = $this->postJson(route('api.auth.login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertSuccessfullApiJsonStructure($loginRes, [
            'access_token',
            'refresh_token',
        ]);
        $this->assertNotNull($loginRes->json('data.access_token'));
        $this->assertNotNull($loginRes->json('data.refresh_token'));

        $refreshToken = $loginRes->json('data.refresh_token');

        $refreshRes = $this->postJson(route('api.auth.refresh'), [
            'refresh_token' => $refreshToken,
        ]);

        $this->assertSuccessfullApiJsonStructure($refreshRes, [
            'access_token',
            'refresh_token',
        ]);
        $this->assertNotNull($refreshRes->json('data.access_token'));
        $this->assertNotNull($refreshRes->json('data.refresh_token'));
    }

    public function testLogout(): void
    {
        $response = $this->asUser()->postJson(route('api.auth.logout'));

        $this->assertSuccessfullApiJsonStructure($response);
    }
}
