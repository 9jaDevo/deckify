<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    protected $fillable = [
    'user_id',
    'input_text',
    'provider',
    'output',
];
    //
}
