<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users_zad;

class adminpanel extends Controller
{
    public function index(Request $req)
    {
        $zad = users_zad::all();
        if($req->session()->has('user_id')) {
        return view('adminpanel',compact('zad'));
        }
        else
        {
            return redirect()->route('login_aut');
        }
    }
    public function status(Request $req)
    {
        if(!$req->session()->has('user_id')) {
            return 'Ошибка доступа';
        }
        $valid = $req -> validate([
            'id'=>'required|max:100|exists:users_zads,id',
            'status'=>'required|string|in:new,in-progress,completed',
            'arhiv'=>'required|boolean'
        ]);
        if($zad = users_zad::findOrFail($valid['id']))
        {
            $zad -> status = $valid['status'];
            $zad -> arhiv = !$valid['arhiv'];
            $zad->save();
        }
        else
        {
            return 'Ошибка заявка недоступна!';
        }
        return 'Заявка обновленна';
    }
}
