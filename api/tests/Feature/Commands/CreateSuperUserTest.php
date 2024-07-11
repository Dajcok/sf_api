<?php
namespace Tests\Feature\Commands;

use Hash;
use Tests\TestCase;
use App\Models\User;

class CreateSuperUserTest extends TestCase
{
    public function testMissingArgs()
    {
        $this->expectException('Symfony\Component\Console\Exception\RuntimeException');

        $this->artisan('make:superuser');
    }

    public function testCreatesASuperUser()
    {
        $name = 'Super Admin';
        $email = 'admin@example.com';
        $password = 'securepassword';

        $this->artisan('make:superuser', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'is_admin' => true,
        ]);

        $user = User::where('email', $email)->first();
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
