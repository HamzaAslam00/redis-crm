<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreHostingClientRequest;
use App\Http\Requests\Backend\UpdateHostingClientRequest;
use App\Models\HostingClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HostingClientController extends Controller
{
    public function index(): View
    {
        return view('backend.hosting.index');
    }

    public function create(): View
    {
        return view('backend.hosting.create', [
            'renewDurations' => HostingClient::$renewDurations,
            'serverUsages' => HostingClient::$serverUsages,
            'currencies' => HostingClient::$currencies,
        ]);
    }

    public function store(StoreHostingClientRequest $request): RedirectResponse
    {
        $client = HostingClient::create($request->validated());

        return redirect()->route('admin.hosting.index')
            ->with('success', "Hosting client {$client->client_name} added.");
    }

    public function edit(HostingClient $hosting): View
    {
        return view('backend.hosting.edit', [
            'client' => $hosting,
            'renewDurations' => HostingClient::$renewDurations,
            'serverUsages' => HostingClient::$serverUsages,
            'currencies' => HostingClient::$currencies,
        ]);
    }

    public function update(UpdateHostingClientRequest $request, HostingClient $hosting): RedirectResponse
    {
        $hosting->update($request->validated());

        return redirect()->route('admin.hosting.index')
            ->with('success', 'Hosting client updated.');
    }

    public function destroy(HostingClient $hosting): RedirectResponse
    {
        $hosting->delete();

        return redirect()->route('admin.hosting.index')
            ->with('success', 'Hosting client deleted.');
    }
}
