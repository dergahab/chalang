<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.builder.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.builder.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages',
        ]);

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => [], // Start empty
            'status' => 'draft',
        ]);

        return redirect()->route('admin.pages.builder', $page->id);
    }

    public function builder($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.builder.editor', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        
        // If it's an AJAX request from the builder
        if ($request->wantsJson()) {
            $page->update(['content' => $request->input('content')]);
            return response()->json(['success' => true]);
        }

        // Standard update
        $page->update($request->only('title', 'slug', 'status'));
        return redirect()->back()->with('success', 'Page updated');
    }
}
