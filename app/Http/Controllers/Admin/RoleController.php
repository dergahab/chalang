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

        $permissions = Permission::all();
        // dd($permissions);

        return view('admin.pages.roles.create', compact('item', 'permissions'));
    }

    public function store(Request $request)
    {
        $item = new Role();
        $item->title = $request->title;
        $item->name = Str::slug($request->title);
        $item->guard_name = 'web';
        $item->save();

        if ($request->has('permissions')) {
            $item->syncPermissions($request->permissions);
        }

        return redirect()->route('role.index');
    }

    public function edit($id)
    {
        $item = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('admin.pages.roles.edit', compact('item', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $item = Role::findById($id);
        $item->title = $request->title;
        $item->save();

        if ($request->has('permissions')) {
            $item->syncPermissions($request->permissions);
        }

        // $this->flashAlert('Role updated!');

        return redirect()->route('role.index');
    }

    public function destroy($id)
    {
        $item = Role::findById($id);

    }
}
