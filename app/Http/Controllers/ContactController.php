<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = Contact::first(); // Mengambil satu record
        return view('LandingPage.contact.index', compact('contact'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
    
        $contact->update([
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'whatsapp_url' => $request->whatsapp_url,
            'email_url' => $request->email_url,
        ]);
    
        return redirect()->route('admin.contact')->with('success', 'Contact berhasil diupdate!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
