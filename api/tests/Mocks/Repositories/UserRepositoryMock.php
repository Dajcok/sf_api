<?php

namespace Tests\Mocks\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Mockery;
use App\Repositories\UserRepository;
use Mockery\LegacyMockInterface;

class UserRepositoryMock
{
    public static function create(): UserRepository|LegacyMockInterface
    {
        $mock = Mockery::mock(UserRepository::class);

        // Find
        $mock->shouldReceive('find')
            ->with(1)
            ->andReturn((new User())->forceFill([
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@doe.com'
            ]));

        // Find
        $mock->shouldReceive('find')
            ->with(4)
            ->andReturn((new User())->forceFill([
                'id' => 4,
                'name' => 'John Doe',
                'email' => 'john@doe2.com'
            ]));

        $mock->shouldReceive('find')
            ->with(9999)
            ->andThrow((new ModelNotFoundException())->setModel(User::class, 9999));

        // All
        $mock->shouldReceive('all')
            ->andReturn(
                new Collection([
                    (new User())->forceFill([
                        'id' => 1,
                        'name' => 'John Doe',
                        'email' => 'john@doe.com'
                    ]),
                    (new User())->forceFill([
                        'id' => 2,
                        'name' => 'Jane Doe',
                        'email' => 'jane@doe.com'
                    ]),
                    (new User())->forceFill([
                        'id' => 3,
                        'name' => 'Random Name',
                        'email' => 'random@name.com'
                    ])
                ])
            );

        // Create
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
            ->andReturn((new User())->forceFill([
                'id' => 4,
                'name' => 'John Doe',
                'email' => 'john@doe2.com'
            ]));

        // Update
        $mock->shouldReceive('update')
            ->with(1, ['name' => 'John Doe', 'email' => 'edited@email.com'])
            ->andReturn((new User())->forceFill([
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'edited@email.com'
            ]));

        $mock->shouldReceive('update')
            ->with(9999, ['name' => 'John Doe', 'email' => 'edited@email.com'])
            ->andThrow((new ModelNotFoundException())->setModel(User::class, 9999));

        // Delete
        $mock->shouldReceive('delete')
            ->with(1)
            ->andReturn(true);

        $mock->shouldReceive('delete')
            ->with(9999)
            ->andThrow((new ModelNotFoundException())->setModel(User::class, 9999));

        return $mock;
    }
}
