<?php

namespace Tests\Unit;

use App\Services\LoginOperatingSystem;
use PHPUnit\Framework\TestCase;

class LoginOperatingSystemTest extends TestCase
{
    public function test_detects_systems_without_confusing_mobile_and_desktop_tokens(): void
    {
        $detector = new LoginOperatingSystem;
        foreach ([
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64)' => 'Windows',
            'Mozilla/5.0 (Linux; Android 14)' => 'Android',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)' => 'iOS / iPadOS',
            'Mozilla/5.0 (X11; CrOS x86_64 14541.0.0)' => 'ChromeOS',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)' => 'macOS',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15) Mobile/15E148' => 'macOS / iPadOS',
            'Mozilla/5.0 (X11; Linux x86_64)' => 'Linux',
            'unknown' => 'No identificado',
        ] as $agent => $expected) {
            $this->assertSame($expected, $detector->detect($agent));
        }
        $this->assertSame('No identificado', $detector->detect(null));
    }
}
