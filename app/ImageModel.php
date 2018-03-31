<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImageModel extends Model
{
	protected $table = 'image';

    function scopeAddImage($query, $data)
    {
        return DB::table('image')
        ->insert($data);
    }
}
