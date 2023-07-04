<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequest;
use App\Http\Requests\TypeUpdateRequest;
use App\Models\Type;
use Illuminate\Http\JsonResponse;

class TypeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Type::all();
            return response()->json(
                $data,
                200
            );
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function store(TypeRequest $request): JsonResponse
    {
        try {
            $data = new Type();
            $data->title_fa = $request->title_fa;
            $data->title_en = $request->title_en;
            $data->save();
            return response()->json([
                'success' => true,
                'last_id' => $data->id,
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function update(TypeUpdateRequest $request, $id): JsonResponse
    {
        try {
            $data = Type::find($id);
            if ($data) {
                $data->title_fa = $request->title_fa ?? $data->title_fa;
                $data->title_en = $request->title_en ?? $data->title_en;
                $data->save();
                return response()->json([
                    'success' => true,
                ], 202);
            } else
                return response()->json([], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = Type::find($id);
            if ($data) {
                $data->delete();
                return response()->json([
                    'success' => true,
                ], 204);
            } else
                return response()->json([], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Type::find($id);
            if ($data) {
                return response()->json(
                    $data,
                    200
                );
            } else
                return response()->json([], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
