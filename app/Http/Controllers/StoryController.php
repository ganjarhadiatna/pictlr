<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

use App\StoryModel;
use App\ImageModel;
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
    function story($id)
    {
        StoryModel::UpdateViewsStory($id);
        $iduserMe = Auth::id();
        $iduser = StoryModel::GetIduser($id);
        $getStory = StoryModel::GetStory($id);
        $newStory = StoryModel::PagRelatedStory(20, $id);
        $tags = TagModel::GetTags($id);
        $statusFolow = FollowModel::Check($iduser, $iduserMe);
        $check = BookmarkModel::Check($id, $iduserMe);
        $images = ImageModel::GetAllImage($id);
        return view('story.index', [
            'title' => 'Story',
            'path' => 'none',
            'getStory' => $getStory,
            'newStory' => $newStory,
            'tags' => $tags,
            'check' => $check,
            'statusFolow' => $statusFolow,
            'images' => $images
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
            return view('compose.edit-story', [
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
        $content = $request['content'];
        if ($id) {
            if ($request->hasFile('image')) {
                $data = array(
                    'description' => $content,
                    'id' => $id
                );
                $rest = StoryModel::AddStory($data);
                if ($rest) {

                    $idstory = StoryModel::GetID();

                    $this->mentions($request['tags'], $idstory);

                    $image = $request->file('image');
                    for ($i=0; $i < count($image); $i++) {
                        //rename file
                        $chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
                        $filename = $id.time().str_replace($chrc, '', $image[$i]->getClientOriginalName());
                        $wd = getImageSize($image[$i])[0];
                        $hg = getImageSize($image[$i])[1];

                        $dtImage = array(
                            'image' => $filename, 
                            'id' => $id,
                            'idstory' => $idstory,
                            'width' => $wd,
                            'height' => $hg
                        );

                        $rest = ImageModel::AddImage($dtImage);
                        if ($rest) {
                            //save image to server
                            //creating thumbnail and save to server
                            $destination = public_path('story/thumbnails/'.$filename);
                            $img = Image::make($image[$i]->getRealPath());
                            $img->resize(400, 400, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($destination);

                            //saving image real to server
                            $destination = public_path('story/covers/');
                            $image[$i]->move($destination, $filename);
                        }
                    }
                    echo $idstory;
                } else {
                    echo 'failed';
                }
            } else {
                echo 'no-file';
            }
        } else {
            echo 'no-login';
        }
    }
    function saveEditting(Request $request)
    {
        $idstory = $request['idstory'];
        $content = $request['content'];
        $tags = $request['tags'];

        $data = array(
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
        $image = ImageModel::GetAllImage($idstory);
        foreach ($image as $dt) {
            unlink(public_path('story/covers/'.$dt->image));
            unlink(public_path('story/thumbnails/'.$dt->image));
        }

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
