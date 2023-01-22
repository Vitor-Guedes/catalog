<?php

namespace Modules\Attribute\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Attribute\Services\Attribute\GroupService;

class GroupController
extends Controller
{
    public function index(GroupService $service)
    {
        $response = $service->index();
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        ResourceCollection::$wrap = 'attribute_groups';
        return ResourceCollection::make($response);
    }

    public function store(GroupService $service, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2|max:30',
            'attribute_family_id' => 'integer|required|exists:attribute_families,id'
        ], [
            'string' => __('attribute::general.group.name.string'),
            'required' => __('attribute::general.group.name.required'),
            'min' => __('attribute::general.group.name.min'),
            'max' => __('attribute::general.group.name.max')
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
            'message' => __('attribute::general.group.store.success'),
            'attribute_group' => $response->toArray()
        ], Response::HTTP_OK);
    }

    public function show(GroupService $service, int $id)
    {
        $response = $service->show($id);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'attribute_group' => $response
        ], Response::HTTP_OK);
    }

    public function update(GroupService $service, Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2|max:30'
        ], [
            'string' => __('attribute::general.group.name.string'),
            'required' => __('attribute::general.group.name.required'),
            'min' => __('attribute::general.group.name.min'),
            'max' => __('attribute::general.group.name.max')
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

    public function destroy(GroupService $service, int $id)
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