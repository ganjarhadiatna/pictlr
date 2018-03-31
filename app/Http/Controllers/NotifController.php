<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\NotifModel;

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
    function notifFollowing(Request $req)
    {
        $iduser = Auth::id();
        $limit = $req['limit'];
        $offset = $req['offset'];
        NotifModel::UpdateNotifF($iduser);
        $rest = NotifModel::GetNotifF($iduser, $limit, $offset);
        echo json_encode($rest);
    }
    function notifCek()
    {
        $iduser = Auth::id();
        $rest = NotifModel::CekNotifStory($iduser) + NotifModel::CekNotifFollowing($iduser);
        echo $rest;
    }
    function notifCekStory()
    {
        $iduser = Auth::id();
        $rest = NotifModel::CekNotifStory($iduser);
        echo $rest;
    }
    function notifCekFollowing()
    {
        $iduser = Auth::id();
        $rest = NotifModel::CekNotifFollowing($iduser);
        echo $rest;
    }
}
