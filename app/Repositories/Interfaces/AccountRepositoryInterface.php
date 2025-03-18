<?php

namespace App\Repositories\Interfaces;

interface AccountRepositoryInterface
{
    public function getAll($page, $perPage);
    public function create(array $data);
    public function findByLogin(string $login);
    public function update(string $login, array $data);
    public function delete(string $login);

    public function getById($id);
}
