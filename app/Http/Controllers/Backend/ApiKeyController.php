<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreApiKeyRequest;
use App\Http\Requests\Backend\UpdateApiKeyRequest;
use App\Models\ApiKey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApiKeyController extends Controller
{
    public function index(): View
    {
        return view('backend.api-keys.index');
    }

    public function create(): View
    {
        return view('backend.api-keys.create', [
            'keyTypes' => ApiKey::$keyTypes,
            'environments' => ApiKey::$environments,
        ]);
    }

    public function store(StoreApiKeyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['key_value'] = encrypt($data['key_value']);
        $data['is_active'] = $request->boolean('is_active', true);

        ApiKey::create($data);

        return redirect()->route('admin.api-keys.index')
            ->with('success', 'API key added successfully.');
    }

    public function edit(ApiKey $apiKey): View
    {
        return view('backend.api-keys.edit', [
            'apiKey' => $apiKey,
            'keyTypes' => ApiKey::$keyTypes,
            'environments' => ApiKey::$environments,
        ]);
    }

    public function update(UpdateApiKeyRequest $request, ApiKey $apiKey): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['key_value'])) {
            $data['key_value'] = encrypt($data['key_value']);
        } else {
            unset($data['key_value']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $apiKey->update($data);

        return redirect()->route('admin.api-keys.index')
            ->with('success', 'API key updated successfully.');
    }

    public function destroy(ApiKey $apiKey): RedirectResponse
    {
        $apiKey->delete();

        return redirect()->route('admin.api-keys.index')
            ->with('success', 'API key deleted.');
    }

    public function reveal(Request $request, ApiKey $apiKey): JsonResponse
    {
        abort_unless(auth()->user()->can('apikey.reveal'), 403);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($apiKey)
            ->withProperties(['ip' => $request->ip()])
            ->log("Revealed API key: {$apiKey->key_label}");

        $apiKey->update(['last_used_at' => now()]);

        return response()->json(['value' => decrypt($apiKey->key_value)]);
    }
}
