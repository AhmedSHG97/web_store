<?php

namespace App\Repositories\SafeTransactions;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\SafeTransactions;

/**
 * Class SafeTransactionRepository.
 */
class SafeTransactionRepository extends BaseRepository implements SafeTransactionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return SafeTransactions::class;
    }
}
