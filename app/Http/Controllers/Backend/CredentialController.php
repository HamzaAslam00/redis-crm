<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCredentialRequest;
use App\Http\Requests\Backend\UpdateCredentialRequest;
use App\Models\Credential;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CredentialController extends Controller
{
    public function index(): View
    {
        return view('backend.credentials.index');
    }

    public function create(): View
    {
        return view('backend.credentials.create', [
            'credTypes' => Credential::$credTypes,
            'ownerTypes' => Credential::$ownerTypes,
        ]);
    }

    public function store(StoreCredentialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = encrypt($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);

        Credential::create($data);

        return redirect()->route('admin.credentials.index')
            ->with('success', 'Credential added successfully.');
    }

    public function edit(Credential $credential): View
    {
        return view('backend.credentials.edit', [
            'credential' => $credential,
            'credTypes' => Credential::$credTypes,
            'ownerTypes' => Credential::$ownerTypes,
        ]);
    }

    public function update(UpdateCredentialRequest $request, Credential $credential): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = encrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $credential->update($data);

        return redirect()->route('admin.credentials.index')
            ->with('success', 'Credential updated successfully.');
    }

    public function destroy(Credential $credential): RedirectResponse
    {
        $credential->delete();

        return redirect()->route('admin.credentials.index')
            ->with('success', 'Credential deleted.');
    }

    public function reveal(Request $request, Credential $credential): JsonResponse
    {
        abort_unless(auth()->user()->can('credential.reveal'), 403);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($credential)
            ->withProperties(['ip' => $request->ip()])
            ->log("Revealed credential: {$credential->system_name}");

        return response()->json(['value' => decrypt($credential->password)]);
    }
}
