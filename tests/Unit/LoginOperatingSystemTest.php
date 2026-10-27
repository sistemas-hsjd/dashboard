<?php

namespace Tests\Unit;

use App\Services\LoginOperatingSystem;
use PHPUnit\Framework\TestCase;

class LoginOperatingSystemTest extends TestCase
{
    public function test_windows_client_hints_override_legacy_user_agent(): void
    {
        $detector = new LoginOperatingSystem;
        $agent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64)';
        $this->assertSame('Windows 11', $detector->detect($agent, 'Windows', '13.0.0'));
        $this->assertSame('Windows 11', $detector->detect($agent, 'Windows', '19.0.0'));
        $this->assertSame('Windows 10', $detector->detect($agent, 'Windows', '10.0.0'));
        foreach ([null, '', 'invalid', '0.0.0'] as $version) {
            $this->assertSame('Windows 7', $detector->detect($agent, 'Windows', $version));
        }
        $this->assertSame('Windows 7', $detector->detect($agent, 'Android', '13.0.0'));
    }

    public function test_detects_systems_without_confusing_mobile_and_desktop_tokens(): void
    {
        $detector = new LoginOperatingSystem;
        foreach ([
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64)' => 'Windows 10 / 11',
            'Mozilla/5.0 (Windows NT 6.1; Win64; x64)' => 'Windows 7',
            'Mozilla/5.0 (Linux; Android 14)' => 'Android 14 (reportado)',
            'Mozilla/5.0 (Linux; Android 10; K)' => 'Android (versión no disponible)',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)' => 'iOS / iPadOS 17.0',
            'Mozilla/5.0 (X11; CrOS x86_64 14541.0.0)' => 'ChromeOS 14541.0.0 (reportado)',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)' => 'macOS 10.15.7 (reportado)',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15) Mobile/15E148' => 'macOS / iPadOS',
            'Mozilla/5.0 (X11; Linux x86_64)' => 'Linux',
            'unknown' => 'No identificado',
        ] as $agent => $expected) {
            $this->assertSame($expected, $detector->detect($agent));
        }
        $this->assertSame('No identificado', $detector->detect(null));
    }
}
