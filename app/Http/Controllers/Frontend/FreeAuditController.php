<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SeoAuditLog;
use App\Services\SeoAuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FreeAuditController extends Controller
{
    public function analyze(Request $request, SeoAuditService $auditService): JsonResponse
    {
        $request->validate([
            'url' => ['required', 'string', 'max:500'],
        ]);

        $url = $request->string('url')->trim()->toString();

        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            $url = 'https://'.$url;
        }

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Please enter a valid website URL.'], 422);
        }

        // Block private/local URLs — prevent SSRF attacks
        $host = parse_url($url, PHP_URL_HOST);
        if ($this->isPrivateHost($host)) {
            return response()->json(['error' => 'Please enter a valid public website URL.'], 422);
        }

        try {
            $result = $auditService->analyze($url);

            $this->recordAudit($request, $url);

            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Analysis failed. The website may be unreachable or the audit service is temporarily unavailable.',
            ], 500);
        }
    }

    private function recordAudit(Request $request, string $url): void
    {
        $ip = $request->ip();
        $geo = [];

        $isPublic = fn (string $addr): bool => (bool) filter_var($addr, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);

        $lookupIp = $ip;

        // Private/local IP (local dev) — detect real public IP of the machine
        if (! $isPublic($ip)) {
            try {
                $res = Http::timeout(2)->get('https://api.ipify.org?format=json');
                if ($res->successful() && $res->json('ip')) {
                    $lookupIp = $res->json('ip');
                }
            } catch (\Throwable) {
                // keep original ip
            }
        }

        if ($isPublic($lookupIp)) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$lookupIp}?fields=country,city,regionName,isp,status");
                if ($response->successful() && $response->json('status') === 'success') {
                    $geo = $response->json();
                }
            } catch (\Throwable) {
                // geo lookup failed silently
            }
        }

        SeoAuditLog::create([
            'url' => $url,
            'ip_address' => $lookupIp,
            'country' => $geo['country'] ?? null,
            'city' => $geo['city'] ?? null,
            'region' => $geo['regionName'] ?? null,
            'isp' => $geo['isp'] ?? null,
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
        ]);
    }

    private function isPrivateHost(?string $host): bool
    {
        if (! $host) {
            return true;
        }

        $lower = strtolower($host);

        // Block localhost and common internal names
        if (in_array($lower, ['localhost', '::1', 'host.docker.internal'])) {
            return true;
        }

        // Block .local, .internal, .lan domains
        if (preg_match('/\.(local|internal|lan|intranet)$/i', $lower)) {
            return true;
        }

        // Resolve and check for private/loopback IP ranges
        $ip = filter_var($host, FILTER_VALIDATE_IP) ? $host : @gethostbyname($host);
        if (! filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        return ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }
}
