<?php

namespace Tests\Unit;

use app\Contracts\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use tests\TestCase;

class BaseRepositoryTestCase extends TestCase
{
    protected RepositoryContract $repository;

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testTheRepositoryImplementsTheRepositoryContract(): void
    {
        $this->assertInstanceOf(RepositoryContract::class, $this->repository);
    }

    public function testTheRepositoryHasAModel(): void
    {
        $this->assertNotNull($this->repository->getModel());
        $this->assertInstanceOf(Model::class, $this->repository->getModel());
    }
}
