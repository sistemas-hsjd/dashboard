<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContentSecurityPolicyTest extends TestCase
{
    public function test_style_nonces_are_unique_and_match_the_page(): void
    {
        $nonces = [];
        foreach ([1, 2] as $request) {
            $response = $this->get('/login')->assertOk();
            preg_match("/'nonce-([^']+)'/", $response->headers->get('Content-Security-Policy'), $matches);
            $this->assertNotEmpty($matches[1]);
            $response->assertSee('nonce="'.$matches[1].'"', false);
            $nonces[] = $matches[1];
        }
        $this->assertNotSame($nonces[0], $nonces[1]);
    }

    public function test_login_and_redirect_responses_include_the_policy(): void
    {
        foreach (['/login', '/inicio'] as $path) {
            $response = $this->get($path);
            $response->assertHeader('Content-Security-Policy');
            $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
            $response->assertHeader('X-Content-Type-Options', 'nosniff');
            $policy = $response->headers->get('Content-Security-Policy');
            $this->assertStringContainsString("default-src 'self'", $policy);
            $this->assertStringContainsString("object-src 'none'", $policy);
            $this->assertStringContainsString("form-action 'self'", $policy);
            $this->assertStringContainsString("frame-ancestors 'self'", $policy);
            $this->assertStringContainsString('https://fonts.googleapis.com', $policy);
            $this->assertStringContainsString('https://fonts.gstatic.com', $policy);
            $this->assertStringNotContainsString('ws://', $policy);
            $this->assertStringNotContainsString("'unsafe-eval'", $policy);
            $this->assertStringNotContainsString("'unsafe-inline'", $policy);
            $this->assertMatchesRegularExpression("/script-src 'self' 'nonce-[A-Za-z0-9+\\/=]+'/", $policy);
            $this->assertStringContainsString("img-src 'self' data: blob:;", $policy);
        }
    }
}
