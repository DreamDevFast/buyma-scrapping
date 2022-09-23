<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Products;
use App\Models\ExhibitSettings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{  
    public function index() {
        
		if(empty($_REQUEST['keyword']))$_REQUEST['keyword'] = "";
		if(empty($_REQUEST['now_page']))$_REQUEST['now_page'] = 1;
        if(empty($_REQUEST['brand']))$_REQUEST['brand'] = "all";

		return view('mypage.dashboard', ['user' => $user, 'keyword'=>$_REQUEST['keyword'], 'now_page'=>$_REQUEST['now_page']]);
	}
}