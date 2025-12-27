<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        $roles = Role::with('abilities')->get();
        return view(
            'Pages.Roles.index',
            [
                'roles' => $roles
            ]
        );
    }

    public function create()
    {
        $this->authorize('create', Role::class);
        return view('Pages.Roles.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'abilities' => 'required|array',
        ]);

        Role::createWithAbilities($request);
        return redirect()->route('Pages.roles.index')->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function show(Role $role)
    {
        $this->authorize('view', $role);
        return view('Pages.Roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $role_abilities = $role->abilities()->pluck('type', 'ability')->toArray();
        $role = Role::with('abilities')->findOrFail($role->id);
        return view('Pages.Roles.edit', ['role' => $role, 'role_abilities' => $role_abilities]);
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'abilities' => 'required|array',
        ]);
        $role->updateWithAbilities($request);
        return redirect()->route('Pages.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('delete', $role);

        Role::destroy($role->id);
        return redirect()->route('Pages.roles.index')->with('success', 'Role deleted successfully.');
    }
}
