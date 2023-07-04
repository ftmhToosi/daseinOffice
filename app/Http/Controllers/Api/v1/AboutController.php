<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutRequest;
use App\Http\Requests\AboutUpdateRequest;
use App\Models\About;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = About::all();
            $gallery = Gallery::where('is_about', '=', true)->get();

            $response = [
                'data' => $data,
                'gallery' => $gallery
            ];
            return response()->json(
                $response,
                200
            );
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function store(AboutRequest $request): JsonResponse
    {
        try {
            $data = new About();

            $file = $request->file('image');
            $path = Storage::put('public/About', $file);
            $data->image = $path;

            $data->body_fa = $request->body_fa;
            $data->chief_name_fa = $request->chief_name_fa;

            $file2 = $request->file('chief_image');
            $path = Storage::put('public/About', $file2);
            $data->chief_image = $path;

            $data->is_english = $request->is_english;
            $data->body_en = $request->body_en;
            $data->chief_name_en = $request->chief_name_en;
            $data->save();

            $images = $request->galleries;
            foreach ($images as $image) {
                $gallery = new Gallery();
                $files = $image['file'];
                $path = Storage::put('public/About', $files);
                $gallery->path = $path;
                $gallery->is_about = true;
                $gallery->save();
            }
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

    public function update(AboutUpdateRequest $request, $id): JsonResponse
    {
        try {
            $data = About::find($id);
            if ($data) {
                $data->body_fa = $request->body_fa ?? $data->body_fa;
                $data->chief_name_fa = $request->chief_name_fa ?? $data->chief_name_fa;
                $data->is_english = $request->is_english ?? $data->is_english;
                $data->body_en = $request->body_en ?? $data->body_en;
                $data->chief_name_en = $request->chief_name_en ?? $data->chief_name_en;
                if ($request->hasFile('image')){
                    Storage::delete($data->image);
                    $file = $request->file('image');
                    $path = Storage::put('public/About', $file);
                    $data->image = $path;
                }
                if ($request->hasFile('chief_image')) {
                    Storage::delete($data->chief_image);
                    $file = $request->file('chief_image');
                    $path = Storage::put('public/About', $file);
                    $data->chief_image = $path;
                }
                $data->save();

                if ($request->has('galleries')) {
                    $images = $request->galleries;
                    $item_data = Gallery::where('is_about', '=', true)->get();
                    foreach ($item_data as $item) {
                        Storage::delete($item['path']);
                        $item->find($item['id'])->delete();
                    }
                    foreach ($images as $image) {
                        $gallery = new Gallery();
                        $files = $image['file'];
                        $path = Storage::put('public/About', $files);
                        $gallery->path = $path;
                        $gallery->is_about = true;
                        $gallery->save();
                    }
                }
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
            $data = About::find($id);
            if ($data) {
                Storage::delete($data->image);
                Storage::delete($data->chief_image);
                $item_data = Gallery::where('is_about', '=', true)->get();
                foreach ($item_data as $item) {
                    Storage::delete($item['path']);
                    $item->find($item['id'])->delete();
                }
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
            $data = About::find($id);
            $gallery = Gallery::where('is_about', '=', true)->get();

            $response = [
                'data' => $data,
                'gallery' => $gallery
            ];
            if ($data) {
                return response()->json(
                    $response,
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
