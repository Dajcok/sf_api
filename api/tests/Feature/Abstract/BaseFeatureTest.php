<?php

namespace tests\Feature\Abstract;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use tests\TestCase;

class BaseFeatureTest extends TestCase
{
//    protected function sendReqAsUser(string $method, string $url, array|null $data = null): TestResponse {
//        $user = User::factory()->create([
//            'password' => 'password123',
//        ]);
//
//        $response = $this->postJson(route('api.auth.login'), [
//            'email' => $user->email,
//            'password' => 'password123',
//        ]);
//
//        $token = $response->json('data.token');
//
//        return $this->withHeader('Authorization', "Bearer $token")->$method($url, $data);
//    }
}
