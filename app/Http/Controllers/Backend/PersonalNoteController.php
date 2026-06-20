<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StorePersonalNoteRequest;
use App\Http\Requests\Backend\UpdatePersonalNoteRequest;
use App\Models\PersonalNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonalNoteController extends Controller
{
    public function index(): View
    {
        return view('backend.notes.index');
    }

    public function create(): View
    {
        return view('backend.notes.create', [
            'colors' => PersonalNote::$colors,
        ]);
    }

    public function store(StorePersonalNoteRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['is_pinned'] = $request->boolean('is_pinned');
        $data['tags'] = $request->input('tags_input')
            ? array_filter(array_map('trim', explode(',', $request->input('tags_input'))))
            : null;

        PersonalNote::create($data);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note created successfully.');
    }

    public function edit(PersonalNote $note): View
    {
        abort_unless($note->user_id === auth()->id() || auth()->user()->hasRole('super-admin'), 403);

        return view('backend.notes.edit', [
            'note' => $note,
            'colors' => PersonalNote::$colors,
        ]);
    }

    public function update(UpdatePersonalNoteRequest $request, PersonalNote $note): RedirectResponse
    {
        abort_unless($note->user_id === auth()->id() || auth()->user()->hasRole('super-admin'), 403);

        $data = $request->validated();
        $data['is_pinned'] = $request->boolean('is_pinned');
        $data['tags'] = $request->input('tags_input')
            ? array_filter(array_map('trim', explode(',', $request->input('tags_input'))))
            : null;

        $note->update($data);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note updated.');
    }

    public function destroy(PersonalNote $note): RedirectResponse
    {
        abort_unless($note->user_id === auth()->id() || auth()->user()->hasRole('super-admin'), 403);

        $note->delete();

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note deleted.');
    }
}
