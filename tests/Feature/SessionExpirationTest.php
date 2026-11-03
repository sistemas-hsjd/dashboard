<?php

namespace Tests\Feature;

use App\Models\UserPortal;
use Tests\TestCase;

class SessionExpirationTest extends TestCase
{
    public function test_heartbeat_preserves_existing_session_and_returns_no_content(): void
    {
        $this->app['env'] = 'production';
        config(['session.lifetime' => 30]);
        $user = new UserPortal;
        $user->setRawAttributes(['id' => 1]);
        $token = str_repeat('a', 40);

        $this->actingAs($user, 'generales')->withSession(['_token' => $token, 'existing' => 'kept'])
            ->postJson('/session/heartbeat', [], ['X-CSRF-TOKEN' => $token])
            ->assertNoContent()->assertHeader('X-Session-Lifetime', '1800')
            ->assertSessionHas('existing', 'kept')->assertSessionHas('_token', $token)
            ->assertSessionHas('portal_last_activity_at');
    }

    public function test_heartbeat_requires_authentication_and_csrf(): void
    {
        $this->postJson('/session/heartbeat')->assertUnauthorized();
        $this->app['env'] = 'production';
        $user = new UserPortal;
        $user->setRawAttributes(['id' => 1]);
        $this->actingAs($user, 'generales')->withSession(['_token' => str_repeat('a', 40)])
            ->postJson('/session/heartbeat')->assertStatus(419);
        $this->postJson('/session/heartbeat', [], ['X-CSRF-TOKEN' => 'wrong'])->assertStatus(419);
    }

    public function test_authenticated_user_can_extend_session_with_configured_lifetime(): void
    {
        config(['session.lifetime' => 15]);
        $user = new UserPortal;
        $user->setRawAttributes(['id' => 1]);

        $this->actingAs($user, 'generales')
            ->postJson('/session/extend')
            ->assertOk()
            ->assertJson(['extended' => true])
            ->assertHeader('X-Session-Lifetime', '900');
    }

    public function test_guest_cannot_extend_session(): void
    {
        $this->postJson('/session/extend')
            ->assertUnauthorized()
            ->assertHeaderMissing('X-Session-Lifetime');
    }
}
