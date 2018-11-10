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
    function scopeUpdateImage($query, $data, $idimage)
    {
        return DB::table('image')
        ->where('image.idimage',$idimage)
        ->update($data);
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
            'idstory',
            'width',
            'height'
        )
        ->where('idstory', $idstory)
        ->get();
    }
    function scopeGetAllImages($query)
    {
        return DB::table('image')
        ->select(
            'idimage',
            'image',
            'id',
            'idstory',
            'width',
            'height'
        )
        ->get();
    }
    function scopeGetDetailImages($query, $idimage)
    {
        return DB::table('image')
        ->select(
            'idimage',
            'image',
            'id',
            'idstory',
            'width',
            'height'
        )
        ->where('idimage', $idimage)
        ->get();
    }
}
