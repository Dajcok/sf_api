<?php

namespace tests\Unit\Repositories\Abstract\Contracts;

interface RepositoryTestContract
{
    public function testFindModelById(): void;

    public function testFindModelByIdThrowsModelNotFoundException(): void;

    public function testGetAllModels(): void;

    public function testCreateModelThrowsQueryException(): void;

    public function testCreateModelSuccessfully(): void;

    public function testUpdateModelSuccessfully(): void;

    public function testUpdateModelThrowsModelNotFoundException(): void;

    public function testDeleteModelSuccessfully(): void;

    public function testDeleteModelThrowsModelNotFoundException(): void;
}
