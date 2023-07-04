<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Models\Media;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Media::all();
//            $data = Media::query()->where('is_enable', '=', true)->get();
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

    public function store(MediaRequest $request): JsonResponse
    {
        try {
//            $data = new Media();
            $media = $request->media;
            foreach ($media as $item){
                $media_item = new Media();
                $media_item->title = $item['title'];
                $media_item->link = $item['link'];
                $media_item->is_enable = $item['is_enable'];
                $media_item->save();
            }

            return response()->json([
                'success' => true,
            ], 201);
        }catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function edit(MediaUpdateRequest $request): JsonResponse
    {
        try {
            $media = $request->media;
            foreach ($media as $item){
                $media_item = Media::find($item['id']);
                $media_item->title = $item['title'] ?? $media_item->title;
                $media_item->link = $item['link'] ?? $media_item->link;
                $media_item->is_enable = $item['is_enable'] ?? $media_item->is_enable;
                $media_item->save();
            }

            return response()->json([
                'success' => true,
            ], 202);
        }catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

//    public function update(MediaUpdateRequest $request)
//    {
//        try {
//
//        }catch (\Exception $exception) {
//            return response()->json([
//                'message' => $exception->getMessage()
//            ], 500);
//        }
//    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = Media::find($id);
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
            $data = Media::find($id);
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
