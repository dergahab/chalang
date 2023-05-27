<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $item = Contact::first(); 
        return view('admin.pages.contact.edit', compact('item'));
    }
}
