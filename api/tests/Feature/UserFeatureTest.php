<?php

namespace tests\Feature;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use tests\TestCase;

class UserFeatureTest extends TestCase
{
    public function retrieveMe(): void
    {
        $response = $this->getJson('/api/user/me');

        $response->assertStatus(SymfonyResponse::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
