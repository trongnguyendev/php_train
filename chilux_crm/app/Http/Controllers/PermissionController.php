<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Permission::class);
        
        $permissions = Permission::with('roles')->latest()->orderBy('id', 'asc')->get();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        Gate::authorize('view', $permission);
        
        $permission->load('roles');
        return view('permissions.show', compact('permission'));
    }
}

