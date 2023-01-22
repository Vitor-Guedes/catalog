<?php

namespace Modules\Attribute\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Modules\Attribute\Services\Attribute\FamilyService;

class FamilyController
extends Controller
{
    public function index(FamilyService $service)
    {
        $response = $service->index();
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        ResourceCollection::$wrap = 'attribute_families';
        return ResourceCollection::make($response);
    }

    public function store(FamilyService $service, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2|max:30|unique:attribute_families,name'
        ], [
            'string' => __('attribute::general.family.name.string'),
            'required' => __('attribute::general.family.name.required'),
            'min' => __('attribute::general.family.name.min'),
            'max' => __('attribute::general.family.name.max'),
            'unique' => __('attribute::general.family.name.unique')
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $data = $validator->validated();
        $response = $service->store($data);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('attribute::general.family.store.success'),
            'attribute_family' => $response->toArray()
        ], Response::HTTP_OK);
    }

    public function show(FamilyService $service, int $id)
    {
        $response = $service->show($id);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'attribute_family' => $response 
        ], Response::HTTP_OK);
    }

    public function update(FamilyService $service, Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2|max:30|unique:attribute_families,name,' . $id
        ], [
            'string' => __('attribute::general.family.name.string'),
            'required' => __('attribute::general.family.name.required'),
            'min' => __('attribute::general.family.name.min'),
            'max' => __('attribute::general.family.name.max'),
            'unique' => __('attribute::general.family.name.unique')
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        $data = $validator->validated();
        $response = $service->update($id, $data);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('attribute::general.family.update.success'),
            'attribute_family' => $response->toArray()
        ]);
    }

    public function destroy(FamilyService $service, int $id)
    {
        $response = $service->destroy($id);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('attribute::general.family.destroy.success')
        ], Response::HTTP_OK);
    }
}