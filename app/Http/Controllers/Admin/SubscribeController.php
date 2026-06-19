<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function index()
    {
        $subscribes = Subscribe::latest()->paginate(10);
        return view('admin.pages.subscribe.index', compact('subscribes'));
    }

    public function destroy($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->delete();
        return back()->with('success', __('admin.messages.delete_success') ?? 'Deleted successfully');
    }
}
