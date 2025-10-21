<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}