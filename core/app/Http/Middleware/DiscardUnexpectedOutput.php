<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiscardUnexpectedOutput
{
    public function handle(Request $request, Closure $next)
    {
        $this->flushUnexpectedBuffers();

        $response = $next($request);

        return $response;
    }

    private function flushUnexpectedBuffers(): void
    {
        while (ob_get_level() > 0) {
            $buffer = ob_get_contents();

            if ($buffer !== false && $buffer !== '') {
                Log::warning('Unexpected bootstrap output discarded before response generation.', [
                    'bytes' => strlen($buffer),
                ]);
            }

            ob_end_clean();
        }
    }
}