<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidatePaymentCallback
{
    /**
     * Validate IP addresses from payment gateways
     *
     * @var array
     */
    protected $allowedIPs = [
        // VNPay IPs (update with actual IPs from VNPay)
        '113.52.45.0/24',
        
        // MoMo IPs (update with actual IPs from MoMo)
        '103.130.221.0/24',
        
        // ZaloPay IPs (update with actual IPs from ZaloPay)
        '123.30.235.0/24',
        
        // Localhost for testing
        '127.0.0.1',
        '::1',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip IP validation in local environment
        if (app()->environment('local')) {
            return $next($request);
        }

        $clientIP = $request->ip();
        
        // Check if IP is allowed
        if (!$this->isIPAllowed($clientIP)) {
            Log::warning('Payment callback from unauthorized IP', [
                'ip' => $clientIP,
                'path' => $request->path(),
                'user_agent' => $request->userAgent()
            ]);
            
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }

        return $next($request);
    }

    /**
     * Check if IP is in allowed list
     */
    private function isIPAllowed(string $ip): bool
    {
        foreach ($this->allowedIPs as $allowedIP) {
            if (strpos($allowedIP, '/') !== false) {
                // CIDR notation
                if ($this->matchCIDR($ip, $allowedIP)) {
                    return true;
                }
            } else {
                // Direct IP match
                if ($ip === $allowedIP) {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * Check if IP matches CIDR notation
     */
    private function matchCIDR(string $ip, string $range): bool
    {
        list($subnet, $bits) = explode('/', $range);
        
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        
        return ($ip & $mask) == $subnet;
    }
}
