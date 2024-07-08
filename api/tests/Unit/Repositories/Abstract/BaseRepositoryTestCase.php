<?php

namespace Tests\Unit\Repositories\Abstract;

use app\Contracts\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Mockery;
use tests\TestCase;

abstract class BaseRepositoryTestCase extends TestCase
{
    protected RepositoryContract $repository;

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @test
     */
    public function testTheRepositoryImplementsTheRepositoryContract(): void
    {
        $this->assertInstanceOf(RepositoryContract::class, $this->repository);
    }

    /**
     * @test
     */
    public function testTheRepositoryHasAModel(): void
    {
        $this->assertNotNull($this->repository->getModel());
        $this->assertInstanceOf(Model::class, $this->repository->getModel());
    }
}
