<?php

namespace App\Services;

class LoginOperatingSystem
{
    public function detect(?string $userAgent, ?string $platform = null, ?string $platformVersion = null): string
    {
        // Client Hints take precedence over legacy or compatibility-mode UA tokens.
        if ($platform === 'Windows' && preg_match('/^\d{1,3}(?:\.\d{1,5}){0,3}$/D', $platformVersion ?? '')) {
            $major = (int) explode('.', $platformVersion)[0];
            if ($major >= 13) return 'Windows 11';
            if ($major >= 1) return 'Windows 10';
        }
        $agent = $userAgent ?? '';
        if (preg_match('/Windows Phone(?: OS)? ([\d.]+)/i', $agent, $match)) {
            return 'Windows Phone '.$match[1];
        }
        if (preg_match('/Windows NT ([\d.]+)/i', $agent, $match)) {
            return 'Windows '.([
                '10.0' => '10 / 11', '6.3' => '8.1', '6.2' => '8',
                '6.1' => '7', '6.0' => 'Vista', '5.1' => 'XP',
            ][$match[1]] ?? 'NT '.$match[1]);
        }
        if (preg_match('/Android ([\d.]+)/i', $agent, $match)) {
            if (preg_match('/Android 10; K\)/i', $agent)) {
                return 'Android (versión no disponible)';
            }
            return 'Android '.$match[1].' (reportado)';
        }
        if (preg_match('/(?:iPhone|iPad|iPod).*?OS ([\d_]+)/i', $agent, $match)) {
            return 'iOS / iPadOS '.str_replace('_', '.', $match[1]);
        }
        if (preg_match('/CrOS \S+ ([\d.]+)/i', $agent, $match)) {
            return 'ChromeOS '.$match[1].' (reportado)';
        }
        if (!preg_match('/Mobile/i', $agent) && preg_match('/Mac OS X ([\d_.]+)/i', $agent, $match)) {
            return 'macOS '.str_replace('_', '.', $match[1]).' (reportado)';
        }
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
