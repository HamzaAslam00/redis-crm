<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreUserRequest;
use App\Http\Requests\Backend\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        return view('backend.users.index');
    }

    public function create(): View
    {
        $roles = Role::where('name', '!=', 'super-admin')->orderBy('name')->get();

        return view('backend.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} created successfully.");
    }

    public function edit(User $user): View
    {
        $roles = Role::where('name', '!=', 'super-admin')->orderBy('name')->get();

        return view('backend.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if (! $user->hasRole('super-admin')) {
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} updated successfully.");
    }

    public function impersonate(User $user): RedirectResponse
    {
        abort_unless(auth()->user()->hasRole('super-admin'), 403);
        abort_if(session()->has('impersonator_id'), 403, 'Already impersonating a user.');
        abort_if($user->hasRole('super-admin'), 403, 'Cannot impersonate a super-admin.');
        abort_if($user->id === auth()->id(), 403, 'Cannot impersonate yourself.');

        session(['impersonator_id' => auth()->id()]);
        Auth::login($user);

        return redirect()->route('admin.dashboard')
            ->with('info', "You are now logged in as {$user->name}.");
    }

    public function stopImpersonating(Request $request): RedirectResponse
    {
        $adminId = session('impersonator_id');
        abort_unless($adminId, 403);

        session()->forget('impersonator_id');
        Auth::loginUsingId($adminId);

        return redirect()->route('admin.users.index')
            ->with('success', 'Returned to your admin account.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('super-admin')) {
            return back()->with('error', 'Cannot delete the super-admin account.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
