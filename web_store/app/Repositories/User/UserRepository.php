<?php

namespace App\Repositories\User;
use App\Models\User;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }
    public function getUserByEmail(string $email)
    {
         return $this->model->email($email)->first();
    }
    public function findUnexpiredUser($id)
    {
        return $this->model->where("id", $id)->where("created_at", ">", Carbon::now()->subHours(1))->first();
    }


    public function getUserByToken($token)
    {
        $rememberToken = DB::table('password_resets')
            ->where('token', $token)
            ->where('created_at', '>',  Carbon::now()->subHours(1))
            ->first();
        if (empty($rememberToken)) {
            return null;
        }
        return $this->model->where("email", $rememberToken->email)->first();
    }
    public function allWithoutAuthed(){
        return User::where('id',"!=",userSession()->id)->get();
    }
}
