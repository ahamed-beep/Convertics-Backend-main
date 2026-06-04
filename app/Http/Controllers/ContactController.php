<?php

namespace App\Http\Controllers;

use App\Mail\AdminNotificationMail;
use App\Mail\UserConfirmationMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        // Save to DB
        Contact::create($data);

        // Email to user
        Mail::to($data['email'])
            ->send(new UserConfirmationMail($data['name']));

        // Email to admin
        Mail::to(env('ADMIN_EMAIL'))
            ->send(new AdminNotificationMail(
                $data['name'],
                $data['email'],
                $data['message']
            ));

        return response()->json([
            'success' => true,
            'message' => 'Your message has been received!'
        ], 201);
    }
}