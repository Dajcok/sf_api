<?php

namespace Tests\Mocks\External;

use App\Models\User;
use Mockery;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthMock
{
    public static function create(): Mockery\MockInterface
    {
        $jwtAuthMock = Mockery::mock('alias:' . JWTAuth::class);

        $jwtAuthMock->shouldReceive('attempt')
            ->with([
                'email' => 'john@doe2.com',
                'password' => 'StrongPWD'
            ])
            ->andReturn('mocked_token');

        $jwtAuthMock->shouldReceive('attempt')
            ->with([
                'email' => 'invalid@example.com',
                'password' => 'invalidpassword'
            ])
            ->andThrow(new TokenInvalidException('Invalid credentials'));

        $jwtAuthMock->shouldReceive('user')
            ->andReturn((new User)->forceFill([
                'id' => 4,
                'name' => 'John Doe',
                'email' => 'john@doe2.com'
            ]));

        $jwtAuthMock->shouldReceive('claims')->with([
            'email' => 'john@doe2.com',
            'id' => 4
        ])->andReturnSelf();

        $jwtAuthMock->shouldReceive('fromUser')->andReturn('mocked_token');

        $jwtAuthMock->shouldReceive('setToken')->with('mocked_token')->andReturnSelf();

        $jwtAuthMock->shouldReceive('getPayload')->andReturnSelf();
        //We don't need to return more attrs
        $jwtAuthMock->shouldReceive('get')->with('id')->andReturn(4);

        $jwtAuthMock->shouldReceive('setToken')->with('invalidtoken')
            ->andThrow(new TokenInvalidException());



        return $jwtAuthMock;
    }
}
