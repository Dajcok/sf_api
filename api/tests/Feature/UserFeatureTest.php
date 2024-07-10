<?php
//
//namespace tests\Feature;
//
//use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
//use tests\Feature\Abstract\BaseFeatureTest;
//
//class UserFeatureTest extends BaseFeatureTest
//{
//    public function testRetrieveMe(): void
//    {
//        $response = $this->sendReqAsUser('getJson', '/api/user/me');
//
//        $response->assertStatus(SymfonyResponse::HTTP_OK)
//            ->assertJsonStructure([
//                'status',
//                'data' => [
//                    'id',
//                    'name',
//                    'email',
//                    'email_verified_at',
//                    'created_at',
//                    'updated_at',
//                ],
//            ]);
//    }
//}
