<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WeblogRequest;
use App\Http\Requests\WeblogUpdateRequest;
use App\Models\Weblog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WeblogController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Weblog::all();
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

    public function store(WeblogRequest $request): JsonResponse
    {
        try {
            $data = new Weblog();
            $data->title_fa = $request->title_fa;
            $data->slug = Str::slug($request->title_en);
            $data->body_fa = $request->body_fa;
            $data->link = $request->link;
//            $data->date = $request->date;
            $data->description = $request->description;
            $data->keyword = $request->keyword;
            if ($request->hasFile('image')){
                $file = $request->file('image');
                $path = Storage::put('public/Weblog', $file);
                $data->image = $path;
            }
            $data->is_english = $request->is_english;
            $data->title_en = $request->title_en;
            $data->body_en = $request->body_en;
            $data->save();
            return response()->json([
                'success' => true,
                'last_id' => $data->id,
            ], 201);
        }catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function update(WeblogUpdateRequest $request, $slug): JsonResponse
    {
        try {
            $data = Weblog::where('slug', $slug)->first();
            if ($data){
                $data->title_fa = $request->title_fa ?? $data->title_fa;
                if ($request->title_en)
                    $data->slug = Str::slug($request->title_en);
                $data->body_fa = $request->body_fa ?? $data->body_fa;
                $data->link = $request->link ?? $data->link;
//             $data->date = $request->date ?? $data->date;
                $data->description = $request->description ?? $data->description;
                $data->keyword = $request->keyword ?? $data->keyword;
                if ($request->hasFile('image')){
                    Storage::delete($data->image);
                    $file = $request->file('image');
                    $path = Storage::put('public/Weblog', $file);
                    $data->image = $path;
                }
                $data->is_english = $request->is_english ?? $data->is_english;
                $data->title_en = $request->title_en ?? $data->title_en;
                $data->body_en = $request->body_en ?? $data->body_en;
                $data->save();
                return response()->json([
                    'success' => true,
                ], 202);
            } else
                return response()->json([], 404);
        }catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function destroy($slug): JsonResponse
    {
        try {
            $data = Weblog::where('slug', $slug)->first();
            if ($data) {
                Storage::delete($data->image);
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

    public function show($slug): JsonResponse
    {
        try {
            $data = Weblog::where('slug', $slug)->first();
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
