<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;

class ContactController extends Controller
{
    /**
     * Envoyer un message de contact (public)
     */
    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();

        $contact = Contact::create($validated);

        return response()->json([
            'message' => 'Message sent successfully',
            'contact' => $contact
        ], 201);
    }

    /**
     * Liste tous les messages de contact (admin)
     */
    public function index()
    {
        $contact = Contact::orderBy('created_at', 'desc')->get();
        
        return ContactResource::collection($contact);
    }

    /**
     * Afficher un message de contact (admin)
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        return new ContactResource($contact);
    }

    /**
     * Supprimer un message de contact
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfuly']);
    }
}