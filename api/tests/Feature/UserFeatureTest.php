<?php

namespace tests\Feature;

use App\Models\User;
use tests\Feature\Abstract\BaseFeatureTest;

class UserFeatureTest extends BaseFeatureTest
{
    public function testRetrieveMeUnauthorized(): void
    {
        $response = $this->withRequiredHeaders()->get(route('api.user.me'));

        $this->assertUnsuccessfullApiJsonStructure($response, status: 401);
        $this->assertEquals('Token not provided', $response->json('message'));
    }

    public function testRetrieveMe(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $response = $this->asUser($user)->get(route('api.user.me'));

        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'name',
            'email',
            'email_verified_at',
        ]);
        $this->assertEquals($user->id, $response->json('data.id'));
        $this->assertEquals($user->name, $response->json('data.name'));
        $this->assertEquals($user->email, $response->json('data.email'));
    }
}
