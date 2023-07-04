<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use App\Models\Media;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Contact::all();
            $media = Media::query()->where('is_enable', '=', true)->get();

            $response = [
                'data' => $data,
                'social_media' => $media
            ];

            return response()->json(
                $response,
                200
            );
        }catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function store(ContactRequest $request): JsonResponse
    {
        try {
            $data = new Contact();
            $data->address_fa = $request->address_fa;
            $data->postal_code = $request->postal_code;
            $data->phone_number = $request->phone_number;
            $data->fax_number = $request->fax_number;
            $data->email = $request->email;
            $data->body_fa = $request->body_fa;
            $data->is_english = $request->is_english;
            $data->address_en = $request->address_en;
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

    public function update(ContactUpdateRequest $request, $id): JsonResponse
    {
        try {
         $data = Contact::find($id);
         if ($data){
             $data->address_fa = $request->address_fa ?? $data->address_fa;
             $data->postal_code = $request->postal_code ?? $data->postal_code;
             $data->phone_number = $request->phone_number ?? $data->phone_number;
             $data->fax_number = $request->fax_number ?? $data->fax_number;
             $data->email = $request->email ?? $data->email;
             $data->body_fa = $request->body_fa ?? $data->body_fa;
             $data->is_english = $request->is_english ?? $data->is_english;
             $data->address_en = $request->address_en ?? $data->address_en;
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

    public function destroy($id): JsonResponse
    {
        try {
            $data = Contact::find($id);
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
            $data = Contact::find($id);
            $media = Media::query()->where('is_enable', '=', true)->get();

            $response = [
                'data' => $data,
                'social_media' => $media
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
