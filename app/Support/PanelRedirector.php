<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelRedirector
{
    private const PANELS = [
        'admin' => [
            'guard' => 'web',
            'login' => 'admin.login',
            'dashboard' => 'admin.dashboard',
            'paths' => ['admin', 'admin/*'],
        ],
        'center' => [
            'guard' => 'center',
            'login' => 'center.login',
            'dashboard' => 'center.dashboard',
            'paths' => ['center', 'center/*'],
        ],
        'trainer' => [
            'guard' => 'trainer',
            'login' => 'trainer.login',
            'dashboard' => 'trainer.dashboard',
            'paths' => ['trainer', 'trainer/*'],
        ],
        'student' => [
            'guard' => 'student',
            'login' => 'student.login',
            'dashboard' => 'student.dashboard',
            'paths' => ['student', 'student/*'],
        ],
    ];

    public function loginUrlForRequest(Request $request): string
    {
        return route($this->panelForRequest($request)['login']);
    }

    public function dashboardUrlForAuthenticatedUser(Request $request): string
    {
        $requestedPanel = $this->panelForRequest($request);

        if (Auth::guard($requestedPanel['guard'])->check()) {
            return route($requestedPanel['dashboard']);
        }

        foreach (self::PANELS as $panel) {
            if (Auth::guard($panel['guard'])->check()) {
                return route($panel['dashboard']);
            }
        }

        return route(self::PANELS['admin']['dashboard']);
    }

    public function loginUrlForGuard(?string $guard): string
    {
        return route($this->panelForGuard($guard)['login']);
    }

    public function dashboardUrlForGuard(?string $guard): string
    {
        return route($this->panelForGuard($guard)['dashboard']);
    }

    private function panelForRequest(Request $request): array
    {
        foreach (self::PANELS as $panel) {
            if ($request->is(...$panel['paths'])) {
                return $panel;
            }
        }

        return self::PANELS['admin'];
    }

    private function panelForGuard(?string $guard): array
    {
        $guard ??= 'web';

        foreach (self::PANELS as $panel) {
            if ($panel['guard'] === $guard) {
                return $panel;
            }
        }

        return self::PANELS['admin'];
    }
}
