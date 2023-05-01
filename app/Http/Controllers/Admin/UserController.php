<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        // $this->canOrAbort('users.index');

        return view('admin.pages.user.index');
    }

    public function create()
    {
        $this->canOrAbort('users.create');

        $item = new User();
        $roles = Role::all();
    

        return view('admin.pages.users.create', compact('item', 'roles'));
    }

    public function store(Request $request)
    {
        $this->canOrAbort('users.create');

        $this->validate($request, [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->person_type = 'admin';
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->person_type ='admin';
        if ($request->password) $user->password = bcrypt($request->password);
        $user->save();

        $user->syncRoles($request->user_role);

        // $this->flashAlert('Admin Əlavə edildi');
        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        // $this->canOrAbort('users.edit');

        $item = $user;
        $roles = Role::all();
      
        return view('admin.pages.user.edit', compact('item', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // $this->canOrAbort('users.edit');

        $this->validate($request, [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->surname = $request->surname;
        if ($request->password) $user->password = bcrypt($request->password);
        $user->save();

        $user->syncRoles($request->user_role);

        // $this->flashAlert('User updated!');
        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $this->canOrAbort('user.delete');
        throw_if(auth()->id() == $user->id);

        $user->delete();

        $this->flashAlert('User deleted!');
        return redirect()->route('user.index');
    }

    public function getUsers(Request $request)
    {
        $users = User::query()
            ->where('name', 'LIKE', '%' . $request->q . '%')
            ->orWhere('username', 'LIKE', '%' . $request->q . '%')
            ->orWhere('email', 'LIKE', '%' . $request->q . '%')
            ->paginate();

        $users->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        });

        return response()->json([
            'results' => $users->items(),
            'pagination' => [
                'more' => $users->hasPages()
            ]
        ]);
    }


    public function account($id = null){
        return "account";
    }
}
