<?php

namespace Modules\Basic\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;

class Service
{
    protected $model;

    protected $builder;

    protected $limit = 10;

    protected $columns = ['*'];
    
    protected $moduleName = 'basic';

    public function __construct(Model $model)
    {
        $this->model = $model;

        $this->builder = $this->model->query();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            return $this->builder->simplePaginate(
                $this->limit,
                $this->columns
            );
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * 
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        try {
            return $this->builder->findOrFail($id);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param array $data
     * 
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function store(array $data = [])
    {
        try {
            return $this->model->create($data);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * @param array $data
     * 
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function update(int $id, array $data = [])
    {
        try {
            $model = $this->model->findOrFail($id);
            $model->update($data);
            return $model;
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param int $id
     * 
     * @return bool
     */
    public function destroy(int $id)
    {
        try {
            return $this->model->findOrFail($id)->delete();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param Exception $e
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleException(Exception $e)
    {
        $message = __($this->moduleName . "::general.error");
        return response()->json([
            'error' => $message
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param int $id
     * 
     * @return Model
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }
}