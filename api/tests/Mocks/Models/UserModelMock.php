<?php

namespace Tests\Mocks\Models;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Mockery;
use App\Models\User;
use Mockery\LegacyMockInterface;

class UserModelMock
{
    public static function create(): User|LegacyMockInterface
    {
        $mock = Mockery::mock(User::class);

        $mock->shouldReceive('find')
            ->with(1)
            ->andReturn((object)['id' => 1, 'name' => 'John Doe', 'email' => 'john@doe.com']);

        $mock->shouldReceive('find')
            ->with(9999)
            ->andThrow((new ModelNotFoundException())->setModel(User::class, 9999));

        $mock->shouldReceive('all')
            ->andReturn(
                collect([
                    (object)['id' => 1, 'name' => 'John Doe', 'email' => 'john@doe.com'],
                    (object)['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@doe.com'],
                    (object)['id' => 3, 'name' => 'Random Name', 'email' => 'random@name.com']
                ])
            );

        $mock->shouldReceive('create')
            ->with(['name' => 'John Doe', 'email' => 'john@doe.com', 'password' => 'StrongPWD'])
            ->andThrow(new QueryException(
                'Mocked connection',
                'SQL',
                [],
                new Exception('SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry')
            ));

        $mock->shouldReceive('create')
            ->with(['name' => 'John Doe', 'email' => 'john@doe2.com', 'password' => 'StrongPWD'])
            ->andReturn((object)['id' => 4, 'name' => 'John Doe', 'email' => 'john@doe2.com']);

        $mock->shouldReceive('update')
            ->with(1, ['name' => 'John Doe', 'email' => 'edited@email.com'])
            ->andReturn((object)['id' => 1, 'name' => 'John Doe', 'email' => 'edited@email.com']);

        $mock->shouldReceive('update')
            ->with(9999, ['name' => 'John Doe', 'email' => 'edited@email.com'])
            ->andThrow((new ModelNotFoundException())->setModel(User::class, 9999));

        $mock->shouldReceive('delete')
            ->with(1)
            ->andReturn(true);

        $mock->shouldReceive('delete')
            ->with(9999)
            ->andThrow((new ModelNotFoundException())->setModel(User::class, 9999));

        return $mock;
    }
}
