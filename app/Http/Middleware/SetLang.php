<?php

namespace App\Http\Middleware;

use App\Enums\Langs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class SetLang
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $langEnum = Langs::fromName(config('app.locale'));
            if (!empty(auth()->user()->lang_id)) {
                $langEnum = Langs::from(auth()->user()->lang_id);
            }
            if ($request->has('lang')) {
                $langEnum = Langs::fromName($request->get('lang'));
            }
            Lang::setLocale($langEnum->name);
        } catch (\Throwable $exception) {}

        return $next($request);
    }
}
