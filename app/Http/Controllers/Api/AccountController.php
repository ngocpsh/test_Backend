<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\GetAccountByIdRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use App\Traits\Api;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    use Api;

    protected AccountRepositoryInterface $accountRepo;

    public function __construct(AccountRepositoryInterface $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = intval($request->get('perPage', 10));
            $page = intval($request->get('page', 1));
            $accounts = $this->accountRepo->getAll($page, $perPage);
            return $this->responseSuccess($accounts, 'Get all accounts success.');

        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->responseError($exception->getMessage());
        }
    }

    public function show(GetAccountByIdRequest $request): JsonResponse
    {
        try {
            $account = $this->accountRepo->getById($request->validated()['id']);
            return $this->responseSuccess($account, 'Get account success.');
        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->responseError($exception->getMessage());
        }
    }

    public function store(CreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $account = $this->accountRepo->create($request->validated());
            DB::commit();

            return $this->responseSuccess($account, 'Account created successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->responseError($exception->getMessage());
        }
    }

    public function update(UpdateAccountRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $account = $this->accountRepo->update($request->login, $request->validated());

            if (!$account) {
                throw new \Exception('Invalid account.');
            }

            DB::commit();

            return $this->responseSuccess($account, 'Account updated successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->responseError($exception->getMessage());
        }
    }

    public function destroy(DeleteAccountRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $deleted = $this->accountRepo->delete($validated['id']);

            DB::commit();
            return $this->responseSuccess($deleted, 'Account deleted successfully.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());

            return $this->responseError($exception->getMessage());
        }
    }

}
