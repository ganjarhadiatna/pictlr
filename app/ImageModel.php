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
    function scopeGetImage($query, $idstory)
    {
        return DB::table('image')
        ->select('image')
        ->where('idstory', $idstory)
        ->get();
    }
    function scopeGetAllImage($query, $idstory)
    {
        return DB::table('image')
        ->select(
            'idimage',
            'image',
            'id',
            'idstory'
        )
        ->where('idstory', $idstory)
        ->get();
    }
}
