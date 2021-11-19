<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }
    public function show(){
        $users = $this->repository->allWithoutAuthed();
        return view("website.layouts.home")->with(['title'=>__("website.titel_dashboard"), "users" => $users]);
    }
}
