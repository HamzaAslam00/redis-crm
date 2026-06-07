<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SeoAuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        try {
            $result = $auditService->analyze($url);

            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Analysis failed. The website may be unreachable or the audit service is temporarily unavailable.',
            ], 500);
        }
    }
}
