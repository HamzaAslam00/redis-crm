<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class FileService
{
    public static function saveResizeImage(UploadedFile $file, string $directory, ?int $width = null, ?int $height = null, ?string $type = null): string
    {
        if (! Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $isPreview = str_contains($directory, 'previews');

        if (! $type) {
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $type = $extension ?: 'jpg';
        }

        $filename = Str::random().(string) time().'.'.strtolower($type);
        $path = "$directory/$filename";

        $manager = ImageManager::usingDriver(Driver::class);
        $img = $manager->decodePath($file->getRealPath());

        if ($width) {
            $img->resizeDown(width: $width);
        }

        if ($height) {
            $img->resizeDown(height: $height);
        }

        if ($isPreview) {
            $img = $img->blur(60);
        }

        $format = match (strtolower($type)) {
            'png' => Format::PNG,
            'gif' => Format::GIF,
            'webp' => Format::WEBP,
            default => Format::JPEG,
        };

        $quality = $isPreview ? 40 : 95;
        $resource = $img->encodeUsingFormat($format, quality: $quality);
        Storage::disk('public')->put($path, $resource, 'public');

        return $path;
    }

    public static function saveDocument(UploadedFile $file, string $directory, ?string $fileName = null): string
    {
        if (! Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $filename = $fileName ?? Str::random().(string) time().'.'.$file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs($directory, $file, $filename);

        return "$directory/$filename";
    }

    public static function saveAnyFile(UploadedFile $file, string $directory, string $fileName): string
    {
        if (str_starts_with($file->getMimeType(), 'image/')) {
            return self::saveResizeImage($file, $directory);
        }

        return self::saveDocument($file, $directory, $fileName);
    }

    public static function deleteFile(string $path): void
    {
        $storagePath = 'app/'.$path;
        if (! empty($path) && file_exists(storage_path($storagePath))) {
            unlink(storage_path($storagePath));
        }

        $publicPath = public_path('storage/'.$path);
        if (! empty($path) && file_exists($publicPath)) {
            unlink($publicPath);
        }
    }
}
