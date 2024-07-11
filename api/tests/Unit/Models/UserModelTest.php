<?php

namespace Tests\Unit\Models;

use App\Models\User;
use DB;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function testTheUserModelHasTheCorrectFillableProperties(): void
    {
        echo env('DB_CONNECTION') . PHP_EOL;
        echo DB::getDefaultConnection() . PHP_EOL;
        $user = new User();
        $this->assertEquals(['name', 'email', 'password', 'is_admin', 'is_anonymous'], $user->getFillable());
    }

    public function testTheUserModelHasTheCorrectHiddenProperties(): void
    {
        $user = new User();
        $this->assertEquals(['password'], $user->getHidden());
    }

    public function testTheUserModelHasTheCorrectCasts(): void
    {
        $user = new User();
        $this->assertEquals([
            'id' => 'int',
            'is_admin' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ], $user->getCasts());
    }
}
