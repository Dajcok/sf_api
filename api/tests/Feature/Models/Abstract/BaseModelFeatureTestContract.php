<?php

namespace tests\Feature\Models\Abstract;

/**
 * This set of test cases is needed to make sure that the Eloquent model is interacting with the database correctly.
 * This interface is used to make sure that the model feature tests implements the correct test cases.
 */
interface BaseModelFeatureTestContract
{
    public function testCreateAndFind(): void;
    public function testUpdate(): void;
    public function testDelete(): void;
    public function testFindAll(): void;
    public function testFindAllWhere(): void;

}
