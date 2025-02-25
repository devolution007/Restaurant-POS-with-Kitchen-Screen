<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Media\StoreFileRequest;
use App\Http\Requests\Media\StoreImageRequest;
use App\Http\Resources\Media\FileResource;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends ApiController
{

    /**
     * Media saving process
     *
     * @param StoreImageRequest $request request
     *
     * @return JsonResponse
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $image = $request->file('file');
        $extension = Str::lower($image->getClientOriginalExtension());
        $file = Media::create(
            [
                'uuid' => Str::uuid(),
                'name' => $image->getClientOriginalName(),
                'size' => $image->getSize(),
                'mime' => $image->getMimeType(),
                'extension' => $extension,
                'disk' => 'public',
                'path' => date('Y') . '/' . date('m'),
                'server_name' => bcrypt($image->getRealPath()) . '.' . $extension,
                'user_id' => Auth::id(),
            ]
        );
        if ($file && $image->storeAs($file->path, $file->server_name, $file->disk)) {
            return response()->json(new FileResource($file));
        }
        return response()->json(
            ['message' => __('Something went wrong try again !')],
            500
        );
    }

    /**
     * Display specific media file
     *
     * @param Media $media file
     *
     * @return JsonResponse
     */
    public function show(Media $media): JsonResponse
    {
        return response()->json(new FileResource($media));
    }

    public function uploadAttachment(StoreFileRequest $request): JsonResponse
    {
        $request->validated();
        $attachment = $request->file('file');
        $file = new Media();
        $file->uuid = Str::uuid();
        $file->name = $attachment->getClientOriginalName();
        $file->size = $attachment->getSize();
        $file->mime = $attachment->getMimeType();
        $file->extension = Str::lower($attachment->getClientOriginalExtension());
        $file->disk = 'private';
        $file->path = 'attachments/' . date('Y') . '/' . date('m');
        $file->server_name = md5($attachment->getRealPath());
        $file->user_id = Auth::id();
        if ($attachment->storeAs($file->path, $file->server_name, $file->disk) && $file->save()) {
            return response()->json(new FileResource($file));
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * @param  string  $uuid
     * @param  Request $request
     * @return StreamedResponse
     * @throws Exception
     */
    public function download(string $uuid, Request $request): StreamedResponse
    {
        $file = Media::where('uuid', $uuid)->firstOrFail();
        if (!Storage::disk($file->disk)->exists($file->path . DIRECTORY_SEPARATOR . $file->server_name)) {
            abort(404);
        }
        return Storage::disk($file->disk)->download($file->path . DIRECTORY_SEPARATOR . $file->server_name, $file->name);
    }
}
