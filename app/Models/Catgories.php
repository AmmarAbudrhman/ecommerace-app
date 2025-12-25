<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catgories extends Model
{
    protected $fillable = [
        'name',
        'image',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
