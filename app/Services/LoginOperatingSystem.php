<?php

namespace App\Services;

class LoginOperatingSystem
{
    public function detect(?string $userAgent): string
    {
        $agent = $userAgent ?? '';
        foreach ([
            'Windows Phone' => '/Windows Phone/i',
            'Android' => '/Android/i',
            'iOS / iPadOS' => '/iPhone|iPad|iPod/i',
            'ChromeOS' => '/CrOS/i',
            'Windows' => '/Windows NT|Windows/i',
            'macOS / iPadOS' => '/Macintosh.*Mobile/i',
            'macOS' => '/Macintosh|Mac OS X/i',
            'Linux' => '/Linux|X11/i',
        ] as $system => $pattern) {
            if (preg_match($pattern, $agent)) {
                return $system;
            }
        }

        return 'No identificado';
    }
}
