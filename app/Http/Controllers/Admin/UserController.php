<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller // ✅ INI WAJIB
{

    /**
     * GET /admin/users
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $perPage = max(1, min($perPage, 100));

        $q = trim((string) $request->query('q', ''));

        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    /**
     * GET /admin/users/{user}
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * GET /admin/users/create
     */
    public function create()
    {
        $roles = $this->allowedRoles();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * POST /admin/users
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'in:super-admin,admin'],
        ]);

        DB::transaction(function () use ($data) {
            // password auto-hash via cast 'hashed' on User model
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'],
            ]);

            $user->syncRoles([$data['role']]);
        });

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    /**
     * GET /admin/users/{user}/edit
     */
    public function edit(User $user)
    {
        $roles = $this->allowedRoles();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * PUT/PATCH /admin/users/{user}
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'], // optional
            'role'     => ['required', 'in:super-admin,admin'],
        ]);

        // Prevent removing super-admin from the last super-admin account
        if ($user->hasRole('super-admin') && $data['role'] !== 'super-admin') {
            $this->ensureNotLastSuperAdmin($user);
        }

        DB::transaction(function () use ($data, $user) {
            $updatePayload = [
                'name'  => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                // auto-hash via cast
                $updatePayload['password'] = $data['password'];
            }

            $user->update($updatePayload);

            // Sync role
            $user->syncRoles([$data['role']]);
        });

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    /**
     * DELETE /admin/users/{user}
     */
    public function destroy(User $user)
    {
        // Don't allow deleting yourself
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Cannot delete your own account.');
        }

        // Don't allow deleting the last super-admin
        if ($user->hasRole('super-admin')) {
            $this->ensureNotLastSuperAdmin($user);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    /**
     * Only allow these roles in UI/forms.
     * Also ensures roles exist in DB.
     */
    private function allowedRoles(): array
    {
        // Ensure roles exist (optional safety)
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        return ['super-admin', 'admin'];
    }

    /**
     * Block operation if target is the last super-admin.
     */
    private function ensureNotLastSuperAdmin(User $target): void
    {
        $count = User::role('super-admin')->count(); // provided by spatie

        if ($count <= 1) {
            abort(403, 'Operation blocked: cannot remove/delete the last super-admin.');
        }

        // optional extra: ensure the only super-admin isn't the target itself
        // (count<=1 already covers it)
    }
}
