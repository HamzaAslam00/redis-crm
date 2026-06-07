<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'service', 'budget', 'website_url', 'message', 'status',
    ];
}
