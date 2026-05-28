<?php

namespace Modules\Center\Http\Controllers\Auth;

use App\Support\PanelRedirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request, PanelRedirector $redirector): RedirectResponse
    {
        Auth::guard('center')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($redirector->loginUrlForGuard('center'));
    }
}
