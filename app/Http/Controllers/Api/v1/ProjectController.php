<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Gallery;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Project::with(['type', 'status', 'scale', 'gallery'])->get();
            return response()->json(
                $data,
                200
            );
        }catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        try {
            $data = new Project();
            $data->title_fa = $request->title_fa;
            $data->slug = Str::slug($request->title_en);
            $data->status_id = $request->status_id;
            $data->scale_id = $request->scale_id;
            $data->body_fa = $request->body_fa;
            $data->location_fa = $request->location_fa;
            $data->team_fa = $request->team_fa;
            $data->client_fa = $request->client_fa;
            $data->supervision_fa = $request->supervision_fa;
            $data->construction_fa = $request->construction_fa;
            $data->landscape_fa = $request->landscape_fa;
            $data->structural_design_fa = $request->structural_design_fa;
            $data->mechanical_fa = $request->mechanical_fa;
            $data->electrical_fa = $request->electrical_fa;
            $data->revolving_rooms_fa = $request->revolving_rooms_fa;
            $data->photographer_fa = $request->photographer_fa;
            $data->is_english = $request->is_english;
            $data->title_en = $request->title_en;
            $data->body_en = $request->body_en;
            $data->location_en = $request->location_en;
            $data->team_en = $request->team_en;
            $data->client_en = $request->client_en;
            $data->supervision_en = $request->supervision_en;
            $data->construction_en = $request->construction_en;
            $data->landscape_en = $request->landscape_en;
            $data->structural_design_en = $request->structural_design_en;
            $data->mechanical_en = $request->mechanical_en;
            $data->electrical_en = $request->electrical_en;
            $data->revolving_rooms_en = $request->revolving_rooms_en;
            $data->photographer_en = $request->photographer_en;


            $file = $request->file('image');
            $path = Storage::put('public/Project', $file);
            $data->image = $path;

            if ($request->hasFile('video')){
                $file2 = $request->file('video');
                $video = Storage::put('public/Project', $file2);
                $data->video = $video;
            }

            $data->save();
            $data->type()->attach($request->type_id);

            $galleries = $request->galleries;
            foreach ($galleries as $gallery){
                $gallery_item = new Gallery();
                $gallery_item->project_id = $data->id;
                $files = $gallery['file'];
                $path = Storage::put('public/Project', $files);
                $gallery_item->path = $path;
                $gallery_item->is_about = false;
                $gallery_item->save();
                $data->gallery()->save($gallery_item);
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

    public function update(ProjectUpdateRequest $request, $slug): JsonResponse
    {
        try {
            $data = Project::where('slug', $slug)->first();
            if ($data) {
                $data->title_fa = $request->title_fa ?? $data->title_fa;
                if ($request->title_en)
                    $data->slug = Str::slug($request->title_en);
                $data->status_id = $request->status_id ?? $data->status_id;
                $data->scale_id = $request->scale_id ?? $data->scale_id;
                $data->body_fa = $request->body_fa ?? $data->body_fa;
                $data->location_fa = $request->location_fa ?? $data->location_fa;
                $data->team_fa = $request->team_fa ?? $data->team_fa;
                $data->client_fa = $request->client_fa ?? $data->client_fa;
                $data->supervision_fa = $request->supervision_fa ?? $data->supervision_fa;
                $data->construction_fa = $request->construction_fa ?? $data->construction_fa;
                $data->landscape_fa = $request->landscape_fa ?? $data->landscape_fa;
                $data->structural_design_fa = $request->structural_design_fa ?? $data->structural_design_fa;
                $data->mechanical_fa = $request->mechanical_fa ?? $data->mechanical_fa;
                $data->electrical_fa = $request->electrical_fa ?? $data->electrical_fa;
                $data->revolving_rooms_fa = $request->revolving_rooms_fa ?? $data->revolving_rooms_fa;
                $data->photographer_fa = $request->photographer_fa ?? $data->photographer_fa;
                $data->is_english = $request->is_english ?? $data->is_english;
                $data->title_en = $request->title_en ?? $data->title_en;
                $data->body_en = $request->body_en ?? $data->body_en;
                $data->location_en = $request->location_en ?? $data->location_en;
                $data->team_en = $request->team_en ?? $data->team_en;
                $data->client_en = $request->client_en ?? $data->client_en;
                $data->supervision_en = $request->supervision_en ?? $data->supervision_en;
                $data->construction_en = $request->construction_en ?? $data->construction_en;
                $data->landscape_en = $request->landscape_en ?? $data->landscape_en;
                $data->structural_design_en = $request->structural_design_en ?? $data->structural_design_en;
                $data->mechanical_en = $request->mechanical_en ?? $data->mechanical_en;
                $data->electrical_en = $request->electrical_en ?? $data->electrical_en;
                $data->revolving_rooms_en = $request->revolving_rooms_en ?? $data->revolving_rooms_en;
                $data->photographer_en = $request->photographer_en ?? $data->photographer_en;
                if ($request->hasFile('image')) {
                    Storage::delete($data->image);
                    $file = $request->file('image');
                    $path = Storage::put('public/Project', $file);
                    $data->image = $path;
                }

                if ($request->hasFile('video')){
                    $file2 = $request->file('video');
                    $video = Storage::put('public/Project', $file2);
                    $data->video = $video;
                }
                $data->save();
                $data->type()->sync($request->type_id);

                if ($request->hasFile('galleries')){
                    $galleries = $request->galleries;

                    $item_data = Gallery::where('project_id', '=', $data->id)->get();
                    foreach ($item_data as $item) {
                        Storage::delete($item['path']);
                        $item->find($item['id'])->delete();
                    }

                    foreach ($galleries as $gallery){
                        $gallery_item = new Gallery();
                        $gallery_item->project_id = $data->id;
                        $files = $gallery['file'];
                        $path = Storage::put('public/Project', $files);
                        $gallery_item->path = $path;
                        $gallery_item->is_about = false;
                        $gallery_item->save();
                        $data->gallery()->save($gallery_item);
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

    public function destroy($slug): JsonResponse
    {
        try {
            $data = Project::where('slug', $slug)->first();
            if ($data) {
                Storage::delete($data->image);
                $item_data = Gallery::where('project_id', '=', $data->id)->get();
                foreach ($item_data as $item) {
                    Storage::delete($item['path']);
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

    public function show($slug): JsonResponse
    {
        try {
            $data = Project::with(['type', 'status', 'scale', 'gallery'])->where('slug', $slug)->first();
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
