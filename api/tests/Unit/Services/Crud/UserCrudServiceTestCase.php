<?php

namespace Tests\Services\Crud;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\Mocks\Models\UserModelMock;
use Tests\Services\Crud\Abstract\Contracts\CrudServiceTestContract;
use tests\TestCase;

class UserCrudServiceTestCase extends TestCase implements CrudServiceTestContract
{
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new UserService(new UserRepository(UserModelMock::create()));
    }

    public function testFindModelById(): void
    {
        $user = $this->service->find(1);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@doe.com', $user->email);
    }

    public function testFindModelByIdThrowsModelNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->find(9999);
    }

    public function testGetAllModels(): void
    {
        $users = $this->service->all();
        $this->assertCount(3, $users);
        $this->assertEquals('John Doe', $users[0]->name);
    }

    public function testCreateModelThrowsQueryException(): void
    {
        $this->expectException(QueryException::class);
        $this->service->create(['name' => 'John Doe', 'email' => 'john@doe.com', 'password' => 'StrongPWD']);
    }

    public function testCreateModelSuccessfully(): void
    {
        $user = $this->service->create(['name' => 'John Doe', 'email' => 'john@doe2.com', 'password' => 'StrongPWD']);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@doe2.com', $user->email);
    }

    public function testUpdateModelSuccessfully(): void
    {
        $user = $this->service->update(1, ['name' => 'John Doe', 'email' => 'edited@email.com']);
        $this->assertEquals('edited@email.com', $user->email);
    }

    public function testUpdateModelThrowsModelNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->update(9999, ['name' => 'John Doe', 'email' => 'edited@email.com']);
    }

    public function testDeleteModelSuccessfully(): void
    {
        $result = $this->service->delete(1);
        $this->assertTrue($result);
    }

    public function testDeleteModelThrowsModelNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->delete(9999);
    }
}
