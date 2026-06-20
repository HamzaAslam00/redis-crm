<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subject',
        'body',
        'variables',
        'default_subject',
        'default_body',
        'is_system',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_system' => 'boolean',
    ];

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    /** Replace {variable} placeholders in subject/body with given values. */
    public function render(array $data, string $field = 'body'): string
    {
        $text = $this->$field ?? '';

        foreach ($data as $key => $value) {
            $text = str_replace('{'.$key.'}', $value, $text);
        }

        return $text;
    }
}
