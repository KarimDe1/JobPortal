<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            if($request->user()->role === 'company')
            return redirect()->intended(RouteServiceProvider :: COMPANY.'?verified=1');
        else
            return redirect()->intended(RouteServiceProvider :: CANDIDATE.'?verified=1');

        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if($request->user()->role === 'company')
            return redirect()->intended(RouteServiceProvider :: COMPANY.'?verified=1');
        else
            return redirect()->intended(RouteServiceProvider :: CANDIDATE.'?verified=1');
    }
}
