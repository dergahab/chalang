<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Models\Lang;
use App\Traits\FileUploader;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    use FileUploader;

    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
        view()->share('langs', $this->langs);
    }

    public function index()
    {
        return view('admin.pages.team-member.index');
    }

    public function create()
    {
        $item = new TeamMember();
        return view('admin.pages.team-member.create', compact('item'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'nullable|image',
            'social_links' => 'nullable|string', // key:value per line
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        foreach ($this->langs as $lang) {
            $transData = $request->validate([
                $lang->code . '.name' => 'required|string',
                $lang->code . '.position' => 'nullable|string',
                $lang->code . '.bio' => 'nullable|string',
                $lang->code . '.specialties' => 'nullable|string', // newline separated
            ])[$lang->code];

            if (isset($transData['specialties'])) {
                $transData['specialties'] = array_filter(array_map('trim', explode("\n", $transData['specialties'])));
            }

            $data[$lang->code] = $transData;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'team-members');
        }

        // Process social links
        if (isset($data['social_links'])) {
            $socialLinks = [];
            $lines = explode("\n", $data['social_links']);
            foreach ($lines as $line) {
                $parts = explode(':', $line, 2);
                if (count($parts) == 2) {
                    $socialLinks[trim($parts[0])] = trim($parts[1]);
                }
            }
            $data['social_links'] = $socialLinks;
        }

        TeamMember::create($data);

        return redirect()->route('admin.team-member.index')->with('success', 'Team Member created successfully');
    }

    public function edit($id)
    {
        $item = TeamMember::findOrFail($id);
        return view('admin.pages.team-member.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = TeamMember::findOrFail($id);

        $data = $request->validate([
            'image' => 'nullable|image',
            'social_links' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        foreach ($this->langs as $lang) {
            $transData = $request->validate([
                $lang->code . '.name' => 'required|string',
                $lang->code . '.position' => 'nullable|string',
                $lang->code . '.bio' => 'nullable|string',
                $lang->code . '.specialties' => 'nullable|string',
            ])[$lang->code];

            if (isset($transData['specialties'])) {
                $transData['specialties'] = array_filter(array_map('trim', explode("\n", $transData['specialties'])));
            }

            $data[$lang->code] = $transData;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'team-members');
        }

        // Process social links
        if (isset($data['social_links'])) {
            $socialLinks = [];
            $lines = explode("\n", $data['social_links']);
            foreach ($lines as $line) {
                $parts = explode(':', $line, 2);
                if (count($parts) == 2) {
                    $socialLinks[trim($parts[0])] = trim($parts[1]);
                }
            }
            $data['social_links'] = $socialLinks;
        }

        $item->update($data);

        return redirect()->route('admin.team-member.index')->with('success', 'Team Member updated successfully');
    }

    public function destroy($id)
    {
        TeamMember::findOrFail($id)->delete();
        return redirect()->route('admin.team-member.index')->with('success', 'Team Member deleted successfully');
    }

    public function is_featured(Request $request)
    {
        $item = TeamMember::find($request->id);
        $item->is_featured = !$item->is_featured;
        $item->save();
    }
}
