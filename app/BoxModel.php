<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BoxModel extends Model
{
    function scopeGetAllBox($query)
    {
        $id = Auth::id();
        return DB::table('boxs')
        ->select(
            'idboxs',
            'title',
            'description'
        )
        ->where('id', $id)
        ->orderBy('title','asc')
        ->get();
    }
    function scopeGetBoxId($query, $idboxs)
    {
        $id = Auth::id();
        return DB::table('boxs')
        ->select(
            'idboxs',
            'title',
            'description'
        )
        ->where('id', $id)
        ->where('idboxs', $idboxs)
        ->get();
    }
    function scopeGetBox($query, $limit)
    {
        $id = Auth::id();
        return DB::table('boxs')
        ->select(
            'boxs.idboxs',
            'boxs.title',
            'boxs.description',
            'boxs.created',
            'boxs.id',
            'users.username',
            'users.foto',
            DB::raw('(select story.cover from bookmark left join story on bookmark.idstory = story.idstory where bookmark.idboxs = boxs.idboxs limit 1 offset 0) as cover1'),
            DB::raw('(select story.cover from bookmark left join story on bookmark.idstory = story.idstory where bookmark.idboxs = boxs.idboxs limit 1 offset 1) as cover2'),
            DB::raw('(select story.cover from bookmark left join story on bookmark.idstory = story.idstory where bookmark.idboxs = boxs.idboxs limit 1 offset 2) as cover3'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idboxs = boxs.idboxs) as ttl_save')
        )
        ->join('users','users.id', '=', 'boxs.id')
        ->where('boxs.id', $id)
        ->orderBy('boxs.title','asc')
        ->paginate($limit);
    }
    function scopeSaveBox($query, $data)
    {
        return DB::table('boxs')->insert($data);
    }
    function scopeDeleteBox($query, $idboxs, $id)
    {
        return DB::table('boxs')
        ->where('boxs.idboxs', $idboxs)
        ->where('boxs.id', $id)
        ->delete();
    }
    function scopeUpdateBox($query, $idboxs, $data)
    {
        return DB::table('boxs')
        ->where('boxs.idboxs', $idboxs)
        ->update($data);
    }
}
