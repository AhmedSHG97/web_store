<?php

namespace App\Repositories\Permission;
use App\Repositories\Permission\PermissionsRepositoryInterface;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Permission;

/**
 * Class PermissionRepository.
 */
class PermissionRepository extends BaseRepository implements PermissionsRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Permission::class;
    }
}
