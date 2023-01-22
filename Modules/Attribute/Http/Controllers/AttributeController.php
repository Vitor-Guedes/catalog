<?php

namespace Modules\Attribute\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Modules\Attribute\Http\Requests\AttributeStoreRequest;
use Modules\Attribute\Http\Requests\AttributeUpdateRequest;
use Modules\Attribute\Services\Attribute\Service;

class AttributeController
extends Controller
{
    public function index(Service $service)
    {
        $response = $service->index();
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        ResourceCollection::$wrap = 'attributes';
        return ResourceCollection::make($response);
    }

    public function store(Service $service, AttributeStoreRequest $request)
    {
        $data = $request->validated();
        $response = $service->store($data);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('attribute::general.store.success'),
            'attribute' => $response->toArray()
        ], Response::HTTP_OK);
    }

    public function show(Service $service, int $id)
    {
        $response = $service->show($id);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'attribute' => $response
        ], Response::HTTP_OK);
    }

    public function update(Service $service, AttributeUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $response = $service->update($id, $data);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('attribute::general.update.success'),
            'attribute' => $response->toArray()
        ]);
    }

    public function destroy(Service $service, int $id)
    {
        $response = $service->destroy($id);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('attribute::general.destroy.success')
        ], Response::HTTP_OK);
    }
}