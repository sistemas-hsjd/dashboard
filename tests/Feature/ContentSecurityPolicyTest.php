<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContentSecurityPolicyTest extends TestCase
{
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
            $this->assertStringContainsString("img-src 'self' data: blob:;", $policy);
        }
    }
}
