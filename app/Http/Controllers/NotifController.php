<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\NotifModel;
use App\ProfileModel;
use App\TagModel;

class NotifController extends Controller
{
    function notifStory(Request $req)
    {
        $iduser = Auth::id();
        $limit = $req['limit'];
        $offset = $req['offset'];
        NotifModel::UpdateNotifS($iduser);
        $rest = NotifModel::GetNotifS($iduser, $limit, $offset);
        echo json_encode($rest);
    }
    function notifCek()
    {
        $iduser = Auth::id();
        $rest = NotifModel::CekNotifStory($iduser);
        echo $rest;
    }
    function notifCekStory()
    {
        $iduser = Auth::id();
        $rest = NotifModel::CekNotifStory($iduser);
        echo $rest;
    }

    function getNotifStory()
    {
        $iduser = Auth::id();
        $limit = 10;
        NotifModel::UpdateNotifS($iduser);
        $rest = NotifModel::GetNotifS($iduser, $limit);
        return response()->json($rest);
    }

    function notifications()
    {
        if (Auth::id()) {
            $id = Auth::id();
        } else {
            $id = 0;
        }
        NotifModel::UpdateNotifS($id);
        $topUsers = ProfileModel::TopUsers($id, 8);
        $topTags = TagModel::TopSmallTags();
        $notif = NotifModel::GetNotifS($id, 10);
        return view('profile.notifications', [
            'title' => 'Notifications',
            'path' => 'notif',
            'topUsers' => $topUsers,
            'topTags' => $topTags,
            'notif' => $notif
        ]);
    }
}
