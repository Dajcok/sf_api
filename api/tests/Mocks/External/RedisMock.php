<?php

namespace Tests\Mocks\External;

use Mockery;

class RedisMock
{
    public static function create(): Mockery\MockInterface
    {
        // Mockovanie Redis Fasády
        $redisMock = Mockery::mock('alias:Illuminate\Support\Facades\Redis');
        $connectionMock = Mockery::mock();
        $redisMock->shouldReceive('connection')
            ->with('default')
            ->andReturn($connectionMock);

        $connectionMock->shouldReceive('set')
            ->with('refresh_token_usr:' . 4, 'mocked_token', 'EX', 604800)
            ->andReturn(true);

        $connectionMock->shouldReceive('get')
            ->with('refresh_token_usr:' . 4)
            ->andReturn('mocked_token');

        $connectionMock->shouldReceive('command')
            ->with('DEL', ['refresh_token_usr:' . 4])
            ->andReturn(true);

        $connectionMock->shouldReceive('set')
            ->with('refresh_token_usr:5', 'mocked_token', 'EX', 604800)
            ->andReturn(true);

        return $connectionMock;
    }
}
