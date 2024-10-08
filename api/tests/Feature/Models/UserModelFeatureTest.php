<?php

namespace tests\Feature\Models;

use App\Enums\UserRoleEnum;
use App\Models\User;
use DB;
use tests\Feature\Models\Abstract\BaseModelFeatureTestContract;
use Tests\TestCase;

class UserModelFeatureTest extends TestCase implements BaseModelFeatureTestContract
{
    public function testCreateAndFind(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
            'role' => UserRoleEnum::RESTAURANT_STAFF->value
        ]);

        //We will make sure that the password is hashed
        $this->assertNotEquals('password123', $user->password);

        $retrievedUser = User::findOrFail($user->id);

        $this->assertEquals($user->id, $retrievedUser->id);
        $this->assertEquals($user->name, $retrievedUser->name);
        $this->assertEquals($user->email, $retrievedUser->email);
        $this->assertEquals($user->email_verified_at, $retrievedUser->email_verified_at);
        $this->assertEquals($user->created_at, $retrievedUser->created_at);
        $this->assertEquals($user->updated_at, $retrievedUser->updated_at);
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $user->update([
            'name' => 'Updated Name',
        ]);

        $retrievedUser = User::findOrFail($user->id);

        $this->assertEquals($user->id, $retrievedUser->id);
        $this->assertEquals('Updated Name', $retrievedUser->name);
        $this->assertEquals($user->email, $retrievedUser->email);
        $this->assertEquals($user->email_verified_at, $retrievedUser->email_verified_at);
        $this->assertEquals($user->created_at, $retrievedUser->created_at);
        $this->assertEquals($user->updated_at, $retrievedUser->updated_at);
    }

    public function testDelete(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $user->delete();

        $this->assertNull(User::find($user->id));
    }

    public function testFindAll(): void
    {
        User::factory(10)->create();

        $users = User::all();

        $this->assertCount(10, $users);
    }

    public function testFindAllWhere(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
        ]);

        $users = User::where('name', '=', 'Test User')->get();

        $this->assertCount(1, $users);
    }
}
