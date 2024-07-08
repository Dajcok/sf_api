<?php

namespace Tests\Unit\Models;

use App\DTO\Input\Auth\UserCreateInputData;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use tests\TestCase;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testTheUserModelHasTheCorrectFillableProperties(): void
    {
        $user = new User();
        $this->assertEquals(['name', 'email', 'password'], $user->getFillable());
    }

    public function testTheUserModelHasTheCorrectHiddenProperties(): void
    {
        $user = new User();
        $this->assertEquals(['password'], $user->getHidden());
    }

    public function testTheUserModelHasTheCorrectCasts(): void
    {
        $user = new User();
        $this->assertEquals(['id' => 'int', 'is_admin' => 'bool', 'created_at' => 'datetime', 'updated_at' => 'datetime'], $user->getCasts());
    }

    public function testCreateSuperuser(): void
    {
        $userPayload = new UserCreateInputData(
            name: 'Superuser',
            email: 'random@adminmail.sk',
            password: 'password',
        );
        $user = User::createSuperuser($userPayload);

        $this->assertNotNull($user);
        $this->assertEquals('Superuser', $user->name);
        $this->assertEquals(true, $user->getIsAdminAttribute());
        //Test if password is hashed
        $this->assertNotEquals('password', $user->password);
    }

    public function testCreateSuperuserUniqueConstraintException(): void
    {
        $userPayload = new UserCreateInputData(
            name: 'Superuser',
            email: 'random@nextadminmail.sk',
            password: 'password',
        );

        User::createSuperuser($userPayload);
        $this->expectException(QueryException::class);
        User::createSuperuser($userPayload);
    }

    public function testCreateUser(): void
    {
        $userPayload = new UserCreateInputData(
            name: 'User',
            email: 'random@usermail.sk',
            password: 'password',
        );
        $user = User::create($userPayload);

        $this->assertNotNull($user);
        $this->assertEquals('User', $user->name);
    }

    public function testCreateUserUniqueConstraintException(): void
    {
        $userPayload = new UserCreateInputData(
            name: 'User',
            email: 'random@nextusermail.sk',
            password: 'password',
        );

        User::create($userPayload);
        $this->expectException(QueryException::class);
        User::create($userPayload);
    }

    public function testIfCantCreateAdminWithUserCreate(): void
    {
        $userPayload = new UserCreateInputData(
            name: 'User',
            email: 'random@nextusermail.sk',
            password: 'password',
        );

        $user = User::create([
            ...$userPayload->toArray(),
            'is_admin' => true,
        ]);

        $this->assertNotNull($user);
        $this->assertEquals('User', $user->name);
        $this->assertEquals(false, $user->getIsAdminAttribute());
    }
}
