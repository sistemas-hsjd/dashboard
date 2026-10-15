<?php

namespace Tests\Feature;

use App\Models\UserPortal;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationCompatibilityTest extends TestCase
{
    public function test_password_assignment_hashes_plain_text_and_preserves_existing_hashes(): void
    {
        $user = new UserPortal;
        $user->password = 'upgrade-test-password';

        $this->assertTrue(Hash::check('upgrade-test-password', $user->password));

        $hash = $user->password;
        $user->password = $hash;

        $this->assertSame($hash, $user->password);
    }

    public function test_login_rehash_does_not_hash_the_password_twice(): void
    {
        $user = $this->getMockBuilder(UserPortal::class)->onlyMethods(['save'])->getMock();
        $user->setRawAttributes(['password' => Hash::make('upgrade-test-password', ['rounds' => 5])]);
        $user->expects($this->once())->method('save')->willReturn(true);

        $provider = new EloquentUserProvider(app('hash'), UserPortal::class);
        $provider->rehashPasswordIfRequired($user, ['password' => 'upgrade-test-password'], true);

        $this->assertTrue(Hash::check('upgrade-test-password', $user->password));
        $this->assertFalse(Hash::needsRehash($user->password));
    }

    public function test_protected_pages_redirect_guests(): void
    {
        foreach (['/inicio', '/registro-accesos', '/cambiar-contrasena'] as $path) {
            $this->get($path)->assertRedirect('/');
        }
    }

    public function test_session_serialization_remains_compatible_with_existing_sessions(): void
    {
        $this->assertSame('php', config('session.serialization'));
    }
}
