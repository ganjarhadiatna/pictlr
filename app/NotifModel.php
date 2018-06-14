<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NotifModel extends Model
{
    function scopeCekNotifStory($query, $iduser)
    {
        return DB::table('notif_s')
        ->where('notif_s.iduser', $iduser)
        ->where('notif_s.status','=','unread')
        ->count();
    }

    function scopeUpdateNotifS($query, $iduser)
    {
        return DB::table('notif_s')
        ->where('iduser', $iduser)
        ->where('status', '=' ,'unread')
        ->update(array('status' => 'read'));
    }
    function scopeAddNotifS($query, $data)
    {
        return DB::table('notif_s')
        ->insert($data);
    }

    function scopeGetNotifS($query, $id, $limit)
    {
        return DB::table('notif_s')
        ->select(
            'notif_s.idnotif_s',
            'notif_s.idstory',
            'notif_s.idbookmark',
            'notif_s.idcomment',
            'notif_s.idlove',
            'notif_s.id',
            'notif_s.iduser',
            'notif_s.type',
            'notif_s.created',
            'users.foto',
            'users.username',
            'users.name',
            'comment.description',
            'image.image'
        )
        ->where('notif_s.iduser', $id)
        ->leftJoin('users','users.id','=','notif_s.id')
        ->leftJoin('comment','comment.idcomment','=','notif_s.idcomment')
        ->leftJoin('story','story.idstory','=','notif_s.idstory')
        ->leftJoin('image','image.idstory','=','story.idstory')
        ->orderBy('notif_s.idnotif_s', 'desc')
        ->simplePaginate($limit);
    }
}
