<?php

namespace App\Repositories\Safe;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Safe;
use App\Repositories\Safe\SafeRepositoryInterface;
/**
 * Class SafeRepository.
 */
class SafeRepository extends BaseRepository implements SafeRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Safe::class;
    }
}
