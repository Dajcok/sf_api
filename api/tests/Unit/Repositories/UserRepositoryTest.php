<?php

namespace Tests\Unit\Repositories;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\Mocks\Models\UserModelMock;
use Tests\Unit\Repositories\Abstract\BaseRepositoryTestCase;
use tests\Unit\Repositories\Abstract\Contracts\RepositoryTestContract;

class UserRepositoryTest extends BaseRepositoryTestCase implements RepositoryTestContract
{
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository(UserModelMock::create());
    }

    /**
     * @test
     */
    public function testFindModelById(): void
    {
        $user = $this->repository->find(1);
        $this->assertEquals('John Doe', $user->name);
    }

    /**
     * @test
     */
    public function testFindModelByIdThrowsModelNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->find(9999);
    }

    /**
     * @test
     */
    public function testGetAllModels(): void
    {
        $users = $this->repository->all();
        $this->assertCount(3, $users);
        $this->assertEquals('John Doe', $users[0]->name);
    }

    /**
     * @test
     */
    public function testCreateModelThrowsQueryException(): void
    {
        $this->expectException(QueryException::class);
        $this->repository->create(['name' => 'John Doe', 'email' => 'john@doe.com', 'password' => 'StrongPWD']);
    }

    /**
     * @test
     */
    public function testCreateModelSuccessfully(): void
    {
        $user = $this->repository->create(['name' => 'John Doe', 'email' => 'john@doe2.com', 'password' => 'StrongPWD']);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@doe2.com', $user->email);
    }

    /**
     * @test
     */
    public function testUpdateModelSuccessfully(): void
    {
        $user = $this->repository->update(1, ['name' => 'John Doe', 'email' => 'edited@email.com']);
        $this->assertEquals('edited@email.com', $user->email);
    }

    /**
     * @test
     */
    public function testUpdateModelThrowsModelNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->update(9999, ['name' => 'John Doe', 'email' => 'edited@email.com']);
    }

    /**
     * @test
     */
    public function testDeleteModelSuccessfully(): void
    {
        $result = $this->repository->delete(1);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function testDeleteModelThrowsModelNotFoundException(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->delete(9999);
    }
}
