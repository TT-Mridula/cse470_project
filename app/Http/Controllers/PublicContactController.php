<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class PublicContactController extends Controller
{
    public function store(Request $request)
    {
        // simple honeypot - real users will not fill this
        if ($request->filled('website')) {
            return back()->withErrors(['message' => 'Invalid submission.'])->withInput();
        }

        $data = $request->validate([
            'name'    => ['required','string','max:120'],
            'email'   => ['required','email','max:150'],
            'phone'   => ['nullable','string','max:50'],
            'subject' => ['nullable','string','max:200'],
            'message' => ['required','string','max:5000'],
        ]);

        $data['meta_ip'] = $request->ip();
        $data['meta_ua'] = $request->userAgent();

        ContactMessage::create($data);

        return back()->with('status', 'Thanks, your message has been sent.');
    }
}
