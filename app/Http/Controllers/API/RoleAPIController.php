<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRoleAPIRequest;
use App\Http\Requests\API\UpdateRoleAPIRequest;
use App\Ecosystem\Models\Role;
use App\Ecosystem\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class RoleController
 * @package App\Http\Controllers\API
 */

class RoleAPIController extends AppBaseController
{
    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     * GET|HEAD /roles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        $this->roleRepository->pushCriteria(new LimitOffsetCriteria($request));
        $roles = $this->roleRepository->all();

        return $this->sendResponse($roles->toArray(), 'Roles retrieved successfully');
    }

    /**
     * Store a newly created Role in storage.
     * POST /roles
     *
     * @param CreateRoleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleAPIRequest $request)
    {
        $input = $request->all();

        $roles = $this->roleRepository->create($input);

        return $this->sendResponse($roles->toArray(), 'Role saved successfully');
    }

    /**
     * Display the specified Role.
     * GET|HEAD /roles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Role $role */
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        return $this->sendResponse($role->toArray(), 'Role retrieved successfully');
    }

    /**
     * Update the specified Role in storage.
     * PUT/PATCH /roles/{id}
     *
     * @param  int $id
     * @param UpdateRoleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleAPIRequest $request)
    {
        $input = $request->all();

        /** @var Role $role */
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role = $this->roleRepository->update($input, $id);

        return $this->sendResponse($role->toArray(), 'Role updated successfully');
    }

    /**
     * Remove the specified Role from storage.
     * DELETE /roles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Role $role */
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $role->delete();

        return $this->sendResponse($id, 'Role deleted successfully');
    }

    public function organizations($id)
    {
        /** @var Role $role */
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            return $this->sendError('Role not found');
        }

        $organizations = $role->organizations()->get();

        if (empty($organizations)) {
            return $this->sendError('No organizations in this role not found');
        }

        return $this->sendResponse($organizations, 'organizations retrieved successfully');
    }
}
