<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $only = $request->get('only'); // unread or read

        $messages = ContactMessage::when($q, function ($query) use ($q) {
                $query->where(function($qq) use ($q) {
                    $qq->where('name','like',"%{$q}%")
                       ->orWhere('email','like',"%{$q}%")
                       ->orWhere('subject','like',"%{$q}%")
                       ->orWhere('message','like',"%{$q}%");
                });
            })
            ->when($only === 'unread', fn($qq) => $qq->where('is_read', false))
            ->when($only === 'read', fn($qq) => $qq->where('is_read', true))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', compact('messages','q','only'));
    }

    public function show(ContactMessage $message)
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success','Marked as read.');
    }

    public function markUnread(ContactMessage $message)
    {
        $message->update(['is_read' => false]);
        return back()->with('success','Marked as unread.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success','Message deleted.');
    }
}
