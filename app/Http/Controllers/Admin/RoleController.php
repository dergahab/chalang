<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $items = Role::query()
            ->withCount('permissions')
            ->paginate();

        return view('admin.pages.roles.index', compact('items'));
    }

    public function create()
    {
        $item = new Role();

        $permissions = Permission::all()->groupBy(function($data) {
            return explode('.', $data->name)[0];
        });

        return view('admin.pages.roles.create', compact('item', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:roles,title',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $item = new Role();
        $item->title = $request->title;
        $item->name = Str::slug($request->title);
        $item->guard_name = 'web';
        $item->save();

        if ($request->has('permissions')) {
            $item->syncPermissions($request->permissions);
        }

        return redirect()->route('role.index')->with('success', 'Rol uğurla yaradıldı.');
    }

    public function edit($id)
    {
        $item = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy(function($data) {
            return explode('.', $data->name)[0];
        });

        return view('admin.pages.roles.edit', compact('item', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:roles,title,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $item = Role::findById($id);
        
        // Prevent editing super-admin name/slug if needed, but allow permissions? 
        // Usually super-admin has all permissions via Gate::before, so editing permissions might be redundant but harmless.
        
        $item->title = $request->title;
        // $item->name = Str::slug($request->title); // Don't change slug to avoid breaking code references
        $item->save();

        if ($request->has('permissions')) {
            $item->syncPermissions($request->permissions);
        }

        return redirect()->route('role.index')->with('success', 'Rol uğurla yeniləndi.');
    }

    public function destroy($id)
    {
        $item = Role::findById($id);
        
        if ($item->name === 'super-admin') {
            return redirect()->back()->with('error', 'Super Admin rolu silinə bilməz!');
        }

        if ($item->users()->count() > 0) {
            return redirect()->back()->with('error', 'Bu rola bağlı istifadəçilər var. Əvvəlcə onları başqa rola keçirin.');
        }

        $item->delete();

        return redirect()->route('role.index')->with('success', 'Rol uğurla silindi.');
    }
}
