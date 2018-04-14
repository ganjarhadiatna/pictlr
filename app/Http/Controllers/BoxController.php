<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\BoxModel;
use App\BookmarkModel;
use App\StoryModel;

class BoxController extends Controller
{
    function index() 
    {
        $id = Auth::id();
        $box = BoxModel::GetBox(16);
        return view('box.index', [
            'title' => 'My Boxs',
            'path' => 'box',
            'box' => $box
        ]);
    }
    function view($idboxs)
    {
        $boxDetail = BoxModel::GetBoxId($idboxs);
        $boxStory = StoryModel::PagUserBoxs(12, $idboxs);
        return view('box.view', [
            'title' => 'My Boxs',
            'path' => 'box',
            'idboxs' => $idboxs,
            'boxDetail' => $boxDetail,
            'boxStory' => $boxStory
        ]);
    }
    function publish(Request $req) 
    {
        $id = Auth::id();
        $title = $req['title'];
        $content = $req['content'];
        $data = array(
            'id' => $id,
            'title' => $title,
            'description' => $content
        );
        $rest = BoxModel::SaveBox($data);
        if ($rest) {
            echo 1;
        } else {
            echo 0;
        }
    }
    function deleteBox(Request $request)
    {
        $iduser = Auth::id();
        $idboxs = $request['idboxs'];
        $rest = BoxModel::DeleteBox($idboxs, $iduser);

        if ($rest) {
            echo "success";
        } else {
            echo "failed";
        }
    }
    function editBox($idboxs, $iduser, $token)
    {
        if ($token === csrf_token()) {
            $box = BoxModel::GetBoxId($idboxs);
            return view('compose.edit-box', [
                'title' => 'Edit Box',
                'path' => 'none',
                'box' => $box
            ]);   
        } else {
            return redirect('/box/'.$idboxs);
        }
    }
    function saveEditing(Request $req)
    {
        $idboxs = $req['idboxs'];
        $title = $req['title'];
        $content = $req['content'];

        $data = array(
            'title' => $title,
            'description' => $content
        );

        $rest = BoxModel::UpdateBox($idboxs, $data);
        if ($rest) {
            echo $idboxs;
        } else {
            echo "failed";
        }
    }
}
