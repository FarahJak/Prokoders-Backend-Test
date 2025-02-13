<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function indexHandler()
    {
        $results = $this->model::paginate(request('per_page') ?? 10);

        return $results;
    }

    public function showHandler($id)
    {
        $result = $this->model::find($id);

        return $result;
    }

    public function storeHandler(array $data)
    {
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);

            $this->model::create($data);

            DB::commit();
            return true;
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return false;
        }
    }

    public function updateHandler($data, $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model::find($id);

            if (array_key_exists('password', $data)) {
                $data['password'] = Hash::make($data['password']);
            }

            $result->update($data);

            DB::commit();
            return true;
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return false;
        }
    }

    public function destroyHandler($id)
    {
        $result = $this->model::find($id);

        if (!$result)
            throw new NotFoundHttpException();

        return $result->delete();
    }
}
