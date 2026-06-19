<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('admin.pages.submission.index');
    }

    public function show($id)
    {
        $item = Submission::findOrFail($id);
        // Mark as read if status is new?
        if ($item->status === 'new') {
            $item->status = 'read';
            $item->save();
        }
        return view('admin.pages.submission.show', compact('item'));
    }

    public function destroy($id)
    {
        Submission::findOrFail($id)->delete();
        return redirect()->route('admin.submission.index')->with('success', 'Submission deleted successfully');
    }
}
