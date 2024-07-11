<?php

namespace Tests\Unit\Models;

use App\Models\User;
use tests\TestCase;

class UserModelTest extends TestCase
{
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
