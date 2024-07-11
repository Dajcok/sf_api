<?php

namespace Tests;

use DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        $this->refreshApplication();
        parent::setUp();
    }
}
