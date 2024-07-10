<?php

namespace tests\Feature;

use tests\Feature\Abstract\BaseFeatureTest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AuthFeatureTest extends BaseFeatureTest
{
    use RefreshDatabase;

    public function testRegisterInvalidEmail(): void
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson(route('api.auth.register'), $payload);

        $this->assertUnsuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY, errors: [
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

        $this->assertUnsuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY, errors: [
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

        $this->assertUnsuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY, errors: [
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

        $this->assertSuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_CREATED, [
            'access_token',
            'refresh_token',
        ]);
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

        $this->assertUnsuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY, errors: [
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

        $this->assertSuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_OK, [
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

        $this->assertSuccessfullApiJsonStructure($loginRes, SymfonyResponse::HTTP_OK, [
            'access_token',
            'refresh_token',
        ]);
        $this->assertNotNull($loginRes->json('data.access_token'));
        $this->assertNotNull($loginRes->json('data.refresh_token'));

        $refreshToken = $loginRes->json('data.refresh_token');

        $refreshRes = $this->postJson(route('api.auth.refresh'), [
            'refresh_token' => $refreshToken,
        ]);

        $this->assertSuccessfullApiJsonStructure($refreshRes, SymfonyResponse::HTTP_OK, [
            'access_token',
            'refresh_token',
        ]);
        $this->assertNotNull($refreshRes->json('data.access_token'));
        $this->assertNotNull($refreshRes->json('data.refresh_token'));
    }

    public function testLogout(): void
    {
        $user = User::factory()->create([
            'password' => 'password123'
        ]);

        $response = $this->postJson(route('api.auth.login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertSuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_OK, [
            'access_token',
            'refresh_token',
        ]);
        $this->assertNotNull($response->json('data.access_token'));
        $this->assertNotNull($response->json('data.refresh_token'));

        $accessTokenValue = $response->json('data.access_token');

        $response = $this->withHeaders([
            'Authorization' => "Bearer $accessTokenValue"
        ])->postJson(route('api.auth.logout'));

        $this->assertSuccessfullApiJsonStructure($response, SymfonyResponse::HTTP_OK);
    }
}
