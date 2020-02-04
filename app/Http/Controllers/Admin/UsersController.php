<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        $query = User::orderByDesc('id');
        $users = $query->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }


    public function store(CreateRequest $request)
    {
        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );

        return redirect()->route('admin.users.show', compact('user'));
    }


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    public function edit(User $user)
    {
        $roles = User::rolesList();
        return view('admin.users.edit', compact('user', 'roles'));
    }


    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email']));

        if ($request['role'] !== $user->role) {
            $user->changeRole($request['role']);
        }

        return redirect()->route('admin.users.show', $user);
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function switch(User $user)
    {
        $user->switchStatus();
        return redirect()->route('admin.users.show', $user);
    }
}
