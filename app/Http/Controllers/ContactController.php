<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInquiry;
use App\Mail\ContactInquiryReceived;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('website.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contactInquiry = ContactInquiry::create($validated);

        // Send thank you email
        Mail::to($contactInquiry->email)->send(
            new ContactInquiryReceived($contactInquiry)
        );

        return redirect()
            ->route('website.contact')
            ->with('toast', [
                'message' => 'Thank you for your message! We will get back to you soon.',
                'type' => 'success'
            ]);
    }

    // Admin methods for managing inquiries
    public function adminIndex()
    {
        $inquiries = ContactInquiry::latest()->paginate(15);
        return view('admin.contact-inquiries.index', compact('inquiries'));
    }

    public function show(ContactInquiry $contactInquiry)
    {
        // Mark as read if it's new
        if ($contactInquiry->status === ContactInquiry::STATUS_NEW) {
            $contactInquiry->update(['status' => ContactInquiry::STATUS_READ]);
        }

        if (request()->ajax()) {
            return view('admin.contact-inquiries.show', compact('contactInquiry'))->render();
        }

        return view('admin.contact-inquiries.show', compact('contactInquiry'));
    }

    public function updateStatus(Request $request, ContactInquiry $contactInquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,responded',
        ]);

        $contactInquiry->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        }

        return redirect()
            ->route('admin.contact-inquiries.index')
            ->with('toast', [
                'message' => 'Contact inquiry status updated successfully.',
                'type' => 'success'
            ]);
    }

    public function destroy(ContactInquiry $contactInquiry)
    {
        $contactInquiry->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Contact inquiry deleted successfully']);
        }

        return redirect()
            ->route('admin.contact-inquiries.index')
            ->with('toast', [
                'message' => 'Contact inquiry deleted successfully.',
                'type' => 'success'
            ]);
    }
}
