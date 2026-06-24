<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogMediaController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:20480', 'mimes:jpg,jpeg,png,gif,webp,mp4,webm,mov'],
        ]);

        $file = $request->file('file');
        $isVideo = in_array(strtolower($file->extension()), ['mp4', 'webm', 'mov']);

        $path = $file->store($isVideo ? 'blog/videos' : 'blog/images', 'public');

        return response()->json([
            'url' => asset('storage/'.$path),
            'type' => $isVideo ? 'video' : 'image',
            'mime' => $file->getMimeType(),
        ]);
    }
}
