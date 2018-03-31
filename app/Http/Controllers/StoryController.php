<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

use App\StoryModel;
use App\TagModel;
use App\FollowModel;
use App\BookmarkModel;

class StoryController extends Controller
{
	function allStory()
	{
		$dt = StoryModel::AllStory(10);
		echo json_encode($dt);
	}
    function story($id, $title = '')
    {
        StoryModel::UpdateViewsStory($id);
        $iduserMe = Auth::id();
        $iduser = StoryModel::GetIduser($id);
        $getStory = StoryModel::GetStory($id);
        $newStory = StoryModel::pagAllStory(20);
        $tags = TagModel::GetTags($id);
        $statusFolow = FollowModel::Check($iduser, $iduserMe);
        $check = BookmarkModel::Check($id, $iduserMe);
        if ($title == '') {
            $newTitle = 'Story';
        } else {
            $newTitle = $title;
        }
        return view('story.index', [
            'title' => $newTitle,
            'path' => 'none',
            'getStory' => $getStory,
            'newStory' => $newStory,
            'tags' => $tags,
            'check' => $check,
            'statusFolow' => $statusFolow
        ]);
    }
    function storyEdit($idstory, $iduser, $token)
    {
        if ($token === csrf_token()) {
            $getStory = StoryModel::GetStory($idstory);
            $restTags = TagModel::GetTags($idstory);
            $temp = [];
            foreach ($restTags as $tag) {
                array_push($temp, $tag->tag);
            }
            $tags = implode(", ", $temp);
            return view('story.edit', [
                'title' => 'Edit Story',
                'path' => 'none',
                'getStory' => $getStory,
                'tags' => $tags
            ]);   
        } else {
            return redirect('/story/'.$idstory);
        }
    }
    function mentions($tags, $idstory)
    {
        $replace = array('[',']','@','+','-','*','<','>','-','(',')',';','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
        $str1 = str_replace($replace, '', $tags);
        $str2 = str_replace(array(', ', ' , ', ' ,'), ',', $str1);
        $tag = explode(',', $str2);
        $count_tag = count($tag);

        for ($i = 0; $i < $count_tag; $i++) {
            if ($tag[$i] != '') {
                $data = array([
                    'tag' => $tag[$i],
                    'link' => '',
                    'idstory' => $idstory
                ]);
                TagModel::AddTags($data);
            }
        }
    }
    function addLoves(Request $request)
    {
        $idstory = $request['idstory'];
        $ttl = $request['ttl-loves'];
        StoryModel::UpdateLoves($idstory, $ttl);
        $rest = StoryModel::GetLoves($idstory);
        echo $rest;
    }
    function publish(Request $request)
    {
    	$id = Auth::id();
    	$cover = $request['cover'];
    	$title = $request['title'];
    	$content = $request['content'];
    	$adult = 0;
    	$commenting = 0;

    	//setting cover
    	$this->validate($request, [
    		'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
    	]);
    	$image = $request->file('cover');
    	$chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
	    $filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());

	    //create thumbnail
	    $destination = 'story/thumbnails/'.$filename;
	    $img = Image::make($image->getRealPath());
	    $img->resize(400, 400, function ($constraint) {
	    	$constraint->aspectRatio();
	    })->save($destination);

	    //create image real
	    $destination = 'story/covers/';
	    $image->move($destination, $filename);

    	$data = array(
    		'title' => $title,
    		'description' => $content,
    		'adult' => $adult,
    		'commenting' => $commenting,
    		'cover' => $filename,
    		'id' => $id
    	);

    	$rest = StoryModel::AddStory($data);
    	if ($rest) {
    		$dt = StoryModel::GetID();
            $this->mentions($request['tags'], $dt);
    		echo $dt;
    	} else {
    		echo "failed";
    	}
    }
    function saveEditting(Request $request)
    {
        $idstory = $request['idstory'];
        $title = $request['title'];
        $content = $request['content'];
        $tags = $request['tags'];

        $data = array(
            'title' => $title,
            'description' => $content
        );

        $rest = StoryModel::UpdateStory($idstory, $data);
        if ($rest) {
            //remove tags
            TagModel::DeleteTags($idstory);
            //editting tags
            $this->mentions($request['tags'], $idstory);
            echo $idstory;
        } else {
            echo "failed";
        }
    }
    function deleteStory(Request $request)
    {
        $iduser = Auth::id();
        $idstory = $request['idstory'];

        //deleting cover

        //deleting like

        //deleting comment

        //deleting story
        $rest = StoryModel::DeleteStory($idstory, $iduser);

        if ($rest) {
            echo "success";
        } else {
            echo "failed";
        }
    }
}
