<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Repositories\Permission\PermissionsRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    //
    public function __construct(UserRepositoryInterface $userRepository, PermissionsRepositoryInterface $permissionRepository)
    {
        $this->repository = $userRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function edit($user_id)
    {
        $user = $this->repository->getById($user_id);
        $permissions = $this->permissionRepository->all();
        $user_permissions = $user->permissions;
        return view("website.user.edit")->with([
            'title' => __('website.title_edit_user'),
            'user' => $user,
            'permissions' => $permissions,
            'user_permissions' => $user_permissions
        ]);
    }

    public function update(UserRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if (session()->has('validation_message')) {
            return redirect()->back()->withErrors(['message' => session("validation_message")])->withInput();
        }
        $this->repository->updateById($request->id, $request->validated());
        return redirect()->back()->with(['success' => __("website.info_data_updated_success")]);
    }

    public function delete(Request $request)
    {
        if (!Gate::allows("modify-users")) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        $this->repository->deleteById($request->id);
        $users = $this->repository->allWithoutAuthed();
        return view("website.user.components.user_table")->with(['users' => $users]);
    }

    public function updateUserPermissions(UserRequest $request)
    {
        if (session()->has('is_authorized')) {
            return redirect()->back()->withErrors(['message' => __("auth.text_no_permission")]);
        }
        if (session()->has('validation_message')) {
            return redirect()->back()->withErrors(['message' => session("validation_message")]);
        }
        $user = $this->repository->getById($request->id);
        $this->repository->detachAllPermossions($user->id);
        if ($request->has('allowed')) {
            foreach ($request->allowed as $slug) {
                if (!$user->hasPermissionTo($slug)) {
                    $user->givePermissionTo($slug);
                }
            }
        }
        return redirect()->back()->with(['success' => __("website.info_data_updated_success")]);
    }
}
