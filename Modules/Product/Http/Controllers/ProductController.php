<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Modules\Product\Http\Requests\ProductStoreRequest;
use Modules\Product\Services\ProductService;

class ProductController
extends Controller
{
    public function index(ProductService $service)
    {
        $response = $service->index();
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        ResourceCollection::$wrap = 'products';
        return ResourceCollection::make($response);
    }

    public function store(ProductService $service, ProductStoreRequest $request)
    {
        $data = $request->validated();
        $response = $service->store($data);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('product::general.store.success'),
            'product' => $response->toArray()
        ], Response::HTTP_OK);
    }

    public function show(ProductService $service, int $id)
    {
        $response = $service->show($id);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'product' => $response
        ], Response::HTTP_OK);
    }

    public function update(ProductService $service, AttributeUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $response = $service->update($id, $data);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('product::general.update.success'),
            'product' => $response->toArray()
        ]);
    }

    public function destroy(ProductService $service, int $id)
    {
        $response = $service->destroy($id);
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }
        return response()->json([
            'message' => __('product::general.destroy.success')
        ], Response::HTTP_OK);
    }
}