<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserResetPasswordEvent;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function delete(Request $request){
        $this->repository->deleteById($request->user_id);
        $users = $this->repository->allWithoutAuthed();
        return view("website.components.user_table")->with(['users' => $users]);
    }

}
