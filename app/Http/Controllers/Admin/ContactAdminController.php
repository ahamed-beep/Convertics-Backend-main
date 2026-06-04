<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    // All contacts
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return response()->json($contacts);
    }

    // Single contact
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    // Mark as read
    public function markRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'read']);
        return response()->json([
            'success' => true,
            'message' => 'Marked as read'
        ]);
    }

    // Delete contact
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully'
        ]);
    }

    // Stats
    public function stats()
    {
        return response()->json([
            'total'  => Contact::count(),
            'unread' => Contact::where('status', 'unread')->count(),
            'read'   => Contact::where('status', 'read')->count(),
        ]);
    }
}