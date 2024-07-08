<?php

namespace Tests\Services\Crud\Abstract;

use app\Contracts\Repositories\RepositoryContract;
use Mockery;
use tests\TestCase;
use app\Contracts\Services\Abstract\CrudServiceContract;

abstract class BaseCrudServiceTestCase extends TestCase
{
    protected CrudServiceContract $service;

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testTheServiceImplementsTheCrudServiceContract(): void
    {
        $this->assertInstanceOf(CrudServiceContract::class, $this->service);
    }

    public function testTheServiceHasARepository(): void
    {
        $this->assertNotNull($this->service->getRepository());
        $this->assertInstanceOf(RepositoryContract::class, $this->service->getRepository());
    }
}
