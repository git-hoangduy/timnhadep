<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('recaptcha_token');

        if (!$token) {
            abort(403, 'Vui lòng xác thực mã Captcha');
        }

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]
        )->json();

        if (
            empty($response['success']) ||
            $response['score'] < config('services.recaptcha.min_score')
        ) {
            abort(403, 'Xác thực mã Captcha không thành công');
        }

        return $next($request);
    }
}
