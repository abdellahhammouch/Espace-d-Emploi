<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class MessageController extends Controller
{

    public function index($id) 
    {
        $user = Auth::user()->with(['messagesSent' , 'messagesReceived']) ;


        return view('chat.show' , compact('user')) ; 

    }


}
