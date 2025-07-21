<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        log_activity('Menambahkan user', ['id'=>$user->id, 'name'=>$user->name]);
        return redirect()->route('users.index')->with('success','User added!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6'
        ]);
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        log_activity('Mengupdate user', ['id'=>$user->id, 'name'=>$user->name]);
        return redirect()->route('users.index')->with('success','User updated!');
    }

    public function destroy(User $user)
    {
        log_activity('Menghapus user', ['id'=>$user->id, 'name'=>$user->name]);
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted!');
    }
}
