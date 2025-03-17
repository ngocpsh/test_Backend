<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\Interfaces\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    protected $model;
    public function __construct(Account $account)
    {
        $this->model = $account;
    }
    public function getAll($page, $perPage)
    {
        return $this->model->query()->paginate($perPage, ['*'], 'page', $page);
    }

    public function create(array $data)
    {
        $data['password'] = sha1($data['password']);
        return $this->model->create($data);
    }
    public function findByLogin(string $login)
    {
        return $this->model->where('login', $login)->first();
    }
    public function update(string $login, array $data)
    {
        $account = $this->findByLogin($login);

        if (!$account) {
            return null;
        }

        if (isset($data['password'])) {
            $data['password'] = sha1($data['password']);
        }

        $account->update($data);
        return $account;
    }

    public function delete(string $login)
    {
        return $this->model->where('login', $login)->delete();
    }

    public function getById($id)
    {
        return $this->model->where('registerID', $id)->first();
    }
}
