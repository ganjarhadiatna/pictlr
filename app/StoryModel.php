<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StoryModel extends Model
{
    protected $table = 'story';

    function scopeGetID($query)
    {
        return DB::table('story')
        ->orderBy('idstory', 'desc')
        ->limit(1)
        ->value('idstory');
    }
    function scopeGetIduser($query, $idstory)
    {
        return DB::table('story')
        ->where('story.idstory', $idstory)
        ->value('story.id');
    }
    function scopeAddStory($query, $data)
    {
        return DB::table('story')->insert($data);
    }
    function scopeUpdateStory($query, $idstory, $data)
    {
        return DB::table('story')->where('story.idstory', $idstory)->update($data);
    }
    function scopeDeleteStory($query, $idstory, $id)
    {
        return DB::table('story')
        ->where('story.idstory', $idstory)
        ->where('story.id', $id)
        ->delete();
    }
    function scopeUpdateViewsStory($query, $idstory)
    {
        $no = (DB::table('story')->where('idstory', $idstory)->value('views'))+1;
        return DB::table('story')
        ->where('story.idstory', $idstory)
        ->update(['story.views' => $no]);
    }
    function scopeGetStory($query, $idstory)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.about',
            'users.created_at',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.idstory', $idstory)
        ->get();
    }
    function scopePagAllStory($query, $limit)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagRelatedStory($query, $limit, $idstory)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.idstory','!=',$idstory)
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagPopularStory($query, $limit)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->orderBy('ttl_comment', 'desc')
        ->paginate($limit);
    }
    /*trending belum benar karena komentar belum ada*/
    function scopePagTrendingStory($query, $limit)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->orderBy('ttl_comment', 'desc')
        ->paginate($limit);
    }
    function scopePagSearchStory($query, $ctr, $limit)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        $searchValues = preg_split('/\s+/', $ctr, -1, PREG_SPLIT_NO_EMPTY);
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.description','like',"%$ctr%")
        ->orWhere('users.name','like',"%$ctr%")
        ->orWhere(function ($q) use ($searchValues)
        {
            foreach ($searchValues as $value) {
                $q->orWhere('story.description','like',"%$value%");
            }
        })
        ->paginate($limit);
    }
    function scopePagTagStory($query, $ctr, $limit)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('tags')
        ->select(
            'tags.idtags',
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('story','story.idstory', '=', 'tags.idstory')
        ->join('users','users.id', '=', 'story.id')
        ->where('tags.tag', 'like', "%{$ctr}%")
        ->orderBy('tags.idtags', 'desc')
        ->groupBy('tags.idstory')
        ->paginate($limit);
    }
    function scopePagCtrStory($query, $ctr, $limit)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('category')
        ->select(
            'category.idcategory',
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('story','story.idcategory', '=', 'category.idcategory')
        ->join('users','users.id', '=', 'story.id')
        ->where('category.title', $ctr)
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagTimelinesStory($query, $limit, $profile)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.id', $id)
        ->orWhere(function ($q) use ($profile)
        {
            foreach ($profile as $value) {
                $q->orWhere('story.id', $value->following);
            }
        })
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagUserStory($query, $limit, $iduser)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('story')
        ->select(
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('users','users.id', '=', 'story.id')
        ->where('story.id', $iduser)
        ->orderBy('story.idstory', 'desc')
        ->paginate($limit);
    }
    function scopePagUserBookmark($query, $limit, $iduser)
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        return DB::table('bookmark')
        ->select(
            'bookmark.idbookmark',
            'story.idstory',
            'story.created',
            'story.description',
            'story.views',
            'users.id',
            'users.name',
            'users.username',
            'users.visitor',
            'users.foto',
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 0) as cover1'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 1) as cover2'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 2) as cover3'),
            DB::raw('(select image.image from image where image.idstory = story.idstory limit 1 offset 3) as cover4'),
            DB::raw('(select count(image.image) from image where image.idstory = story.idstory ) as ttl_image'),
            DB::raw('(select count(story.idstory) from story where story.id = users.id) as ttl_story'),
            DB::raw('(select count(comment.idcomment) from comment where comment.idstory = story.idstory) as ttl_comment'),
            DB::raw('(select count(bookmark.idbookmark) from bookmark where bookmark.idstory = story.idstory) as ttl_save'),
            DB::raw('(select count(love.idlove) from love where love.idstory = story.idstory) as ttl_love'),
            DB::raw('(select bookmark.idbookmark from bookmark where bookmark.idstory = story.idstory and bookmark.id = '.$id.' limit 1) as is_save'),
            DB::raw('(select love.idlove from love where love.idstory = story.idstory and love.id = '.$id.' limit 1) as is_love')
        )
        ->join('story','story.idstory', '=', 'bookmark.idstory')
        ->join('users','users.id', '=', 'story.id')
        ->where('bookmark.id', $iduser)
        ->orderBy('bookmark.idbookmark', 'desc')
        ->paginate($limit);
    }

}
