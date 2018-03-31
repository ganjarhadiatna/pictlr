<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CommentModel;
use App\NotifModel;
use App\StoryModel;

class CommentController extends Controller
{
    function add(Request $req)
    {
    	if (Auth::id()) {
    		$id = Auth::id();
    	} else {
    		$id = 0;
    	}
    	$idstory = $req['idstory'];
    	$description = $req['description'];
    	$data = array(
    		'description' => $description,
    		'idstory' => $idstory,
    		'id' => $id
    	);
    	$rest = CommentModel::Add($data);
    	if ($rest) {
            //get user id
            $iduser = StoryModel::GetIduser($idstory);
            if ($id != $iduser) {
                //get idcomment
                $idcomment = CommentModel::GetIdcomment($idstory, $id);
                //add notif comment
                $notif = array(
                    'idstory' => $idstory,
                    'idcomment' => $idcomment,
                    'id' => $id,
                    'iduser' => $iduser,
                    'title' => 'Commented on your Story',
                    'type' => 'comment'
                );
                NotifModel::AddNotifS($notif);
            }
    		echo $idstory;
    	} else {
    		echo "failed";
    	}
    }
    function delete(Request $req)
    {
    	$idcomment = $req['idcomment'];
    	$rest = CommentModel::Remove($idcomment);
    	if ($rest) {
    		echo "success";
    	} else {
    		echo "failed";
    	}
    }
    function get($idstory, $offset, $limit)
    {
    	$rest = CommentModel::GetID($idstory, $offset, $limit);
    	echo json_encode($rest);
    }
}
