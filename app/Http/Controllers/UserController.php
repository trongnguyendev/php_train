<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách tất cả users
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);
        
        // $users = User::latest()->paginate(10);
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Hiển thị form tạo user mới
     */
    public function create()
    {
        Gate::authorize('create', User::class);
        
        return view('users.create');
    }

    /**
     * Lưu user mới vào database
     */
    public function store(Request $request)
    {
        Gate::authorize('create', User::class);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ], [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('users.index')->with('success', 'Tạo tài khoản thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết của user
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);
        
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa user
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        
        $roles = Role::all();
        $user->load('roles');
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Cập nhật thông tin user
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable'
        ], [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Sync roles if provided
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Xóa user
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa tài khoản thành công!');
    }

    /**
     * Hiển thị form gán roles cho user
     */
    public function assignRoles(User $user)
    {
        Gate::authorize('update', $user);
        
        $roles = Role::all();
        $user->load('roles');
        return view('users.assign-roles', compact('user', 'roles'));
    }

    /**
     * Gán roles cho user
     */
    public function syncRoles(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        
        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->syncRoles($request->roles ?? []);

        return redirect()->route('users.index')->with('success', 'Gán roles thành công!');
    }
}
