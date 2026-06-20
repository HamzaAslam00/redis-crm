<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Mail\TemplateMail;
use App\Models\ContactInquiry;
use App\Models\ContactReply;
use App\Models\EmailTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        return view('backend.contacts.index');
    }

    public function show(ContactInquiry $contact): View
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read', 'read_at' => now()]);
        }

        $contact->load(['replies.sender']);

        return view('backend.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, ContactInquiry $contact): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:new,read,replied'],
        ]);

        $contact->update(['status' => $request->status]);

        return back()->with('success', 'Status updated.');
    }

    public function updateNotes(Request $request, ContactInquiry $contact): RedirectResponse
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $contact->update(['admin_notes' => $request->admin_notes]);

        return back()->with('notes_saved', true);
    }

    public function destroy(ContactInquiry $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Message deleted.');
    }

    public function reply(Request $request, ContactInquiry $contact): RedirectResponse
    {
        $data = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $reply = ContactReply::create([
            'contact_inquiry_id' => $contact->id,
            'sent_by' => auth()->id(),
            'to_email' => $contact->email,
            'to_name' => $contact->name,
            'subject' => 'Re: Your Inquiry — Redis Solution',
            'body' => $data['body'],
            'sent_at' => now(),
        ]);

        $template = EmailTemplate::findBySlug('contact-reply');

        if ($template) {
            Mail::to($contact->email, $contact->name)->send(new TemplateMail($template, [
                'client_name' => $contact->name,
                'reply_body' => $data['body'],
                'original_message' => $contact->message ?? '',
                'admin_name' => auth()->user()->name,
                'company_name' => setting('company_name', 'Redis Solution Pvt. Ltd.'),
            ]));
        } else {
            Mail::to($contact->email, $contact->name)->send(new ContactReplyMail($reply));
        }

        $contact->update(['status' => 'replied']);

        return back()->with('replied', true);
    }
}
