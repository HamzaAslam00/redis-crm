<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

function getFullName(object $user): string
{
    return ucwords($user->first_name.' '.$user->last_name);
}

function getImage(?string $image, bool $isAvatar = false, bool $withBaseurl = false): string
{
    $errorImage = $isAvatar ? url('/assets/backend/images/users/avatar-1.jpg') : url('/assets/no_image.png');

    return ! empty($image)
        ? ($withBaseurl ? url('/storage/'.$image) : Storage::url($image))
        : $errorImage;
}

function getFiles(?string $fileName): string
{
    return empty($fileName) ? '' : url('/storage/'.$fileName);
}

function statusClasses(string $status): string
{
    return match ($status) {
        'active', 'approved', 'accepted', 'completed', 'final', 'replied' => 'success',
        'inactive', 'rejected', 'expired', 'cancelled', 'required' => 'danger',
        'pending', 'pending_cancellation' => 'warning',
        default => 'muted',
    };
}

function addEllipsis(string $text, int $max = 30): string
{
    return strlen($text) > $max ? mb_substr($text, 0, $max, 'UTF-8').'...' : $text;
}

function isValue(mixed $value): mixed
{
    return ($value !== 'undefined' && $value !== null && ! empty($value)) ? $value : 'N/A';
}

function formatString(string $key, bool $reverse = false): string
{
    return $reverse
        ? str_replace([' ', "'"], '_', strtolower($key))
        : str_replace(['_', '-'], ' ', strtolower($key));
}

function isActive(array|string $routes = [], array $params = []): string
{
    $routes = (array) $routes;

    foreach ($routes as $route) {
        if (! request()->routeIs($route)) {
            continue;
        }

        if (empty($params)) {
            return 'active';
        }

        $match = true;
        foreach ($params as $key => $value) {
            if (request()->route($key) != $value) {
                $match = false;
                break;
            }
        }

        if ($match) {
            return 'active';
        }
    }

    return '';
}

function getAssignedPermissionsCount(object $role, string $group): int
{
    return $role->permissions()->where('group', $group)->count();
}

function setting(string $key, mixed $default = null): mixed
{
    static $settings = null;

    if ($settings === null) {
        try {
            $settings = Setting::all()->keyBy('key');
        } catch (Throwable) {
            return $default;
        }
    }

    $setting = $settings[$key] ?? null;

    if (! $setting) {
        return $default;
    }

    return $setting->value ?? json_decode($setting->json_value, true);
}
