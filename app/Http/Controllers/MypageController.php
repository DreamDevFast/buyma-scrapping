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
	public $amazon_category_array = array();

	public function index() {
		$user = Auth::user();
		if(empty($_REQUEST['skeyword']))$_REQUEST['skeyword'] = "";
		if(empty($_REQUEST['now_page']))$_REQUEST['now_page'] = 1;
		return view('mypage.dashboard', ['user' => $user, 'skeyword'=>$_REQUEST['skeyword'], 'now_page'=>$_REQUEST['now_page']]);
	}
	public function goatpage(){
		$user = Auth::user();
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.goat.com/')->where('user_id', Auth::user()->id)->latest()->paginate(10);
		error_log('goat');
		error_log($products);
		if(!empty($_REQUEST['skeyword']) && $_REQUEST['skeyword'] != ""){
			$products = Products::where('site_url', 'https://www.goat.com/')->where('product_name', 'LIKE', "%{$_REQUEST['skeyword']}%")->where('user_id', Auth::user()->id)->latest()->paginate(10);
		}
		if(empty($_REQUEST['skeyword']))$_REQUEST['skeyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
        
		return view('mypage.goatpage', ['user' => $user, 'products'=>$products, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'skeyword'=>$_REQUEST['skeyword']]);
	}


	public function louipage(){
		$user = Auth::user();
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('user_id', Auth::user()->id)->latest()->paginate(10);
	
		if(!empty($_REQUEST['skeyword']) && $_REQUEST['skeyword'] != ""){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('product_name', 'LIKE', "%{$_REQUEST['skeyword']}%")->where('user_id', Auth::user()->id)->latest()->paginate(10);
		}
		if(empty($_REQUEST['skeyword']))$_REQUEST['skeyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
        
		return view('mypage.louipage', ['user' => $user, 'products'=>$products, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'skeyword'=>$_REQUEST['skeyword']]);
	}

	public function changepass(){
		$user = Auth::user();
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('user_id', Auth::user()->id)->latest()->paginate(10);
	
		if(!empty($_REQUEST['skeyword']) && $_REQUEST['skeyword'] != ""){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('product_name', 'LIKE', "%{$_REQUEST['skeyword']}%")->where('user_id', Auth::user()->id)->latest()->paginate(10);
		}
		if(empty($_REQUEST['skeyword']))$_REQUEST['skeyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
		return view('mypage.changepass', ['user' => $user, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'skeyword'=>$_REQUEST['skeyword']]);
	}

	public function changepass_check(request $request){
		$user = Auth::user();
		$input = $request->all();
		//echo Hash::make($input['pass']);
		$user->forceFill([
            'password' => Hash::make($input['pass']),
        ])->save();
		return redirect('./');

	}
	
	public function exhibitsettings() {
		$user = Auth::user();
		$exhibitsetting = ExhibitSettings::where('user_id', $user->id)->first();
		$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('user_id', Auth::user()->id)->latest()->paginate(10);
	
		if(!empty($_REQUEST['skeyword']) && $_REQUEST['skeyword'] != ""){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('product_name', 'LIKE', "%{$_REQUEST['skeyword']}%")->where('user_id', Auth::user()->id)->latest()->paginate(10);
		}
		if(empty($_REQUEST['skeyword']))$_REQUEST['skeyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
		return view('mypage.exhibitsettings', ['exhibitsettings' => $exhibitsetting, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'skeyword'=>$_REQUEST['skeyword']]);
	}

	public function count(request $request){
		$cnt = 0;
		$input = $request->all();
		if($input["sel"] == 1){
			$products = Products::where('site_url', 'https://www.goat.com/')->where('user_id', Auth::user()->id)->get();
			$cnt = count($products);
		}

		if($input["sel"] == 2){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('user_id', Auth::user()->id)->get();
			$cnt = count($products);
		}

		if($input["sel"] == 3){
			$products = Products::where('site_url', 'https://it.burberry.com/')->where('user_id', Auth::user()->id)->get();
			$cnt = count($products);
		}

		if($input["sel"] == 4){
			$products = Products::where('site_url', 'https://www.dior.com/')->where('user_id', Auth::user()->id)->get();
			$cnt = count($products);
		}
		return $cnt;
	}

	public function csv_down(request $request){
		$input = $request->all();
		$data = "";
		$filename = "";
		if($input["sel"] == 1){
			$products = Products::where('site_url', 'https://www.goat.com/')->where('user_id', Auth::user()->id)->get();
			
			foreach($products as $pro){
				$data .= $pro['product_id'].",".$pro['product_name'].",".$pro['brand'].",".$pro['shop_name_'].",".$pro['price_type'].",".$pro['product_price']."\n";
			}

			$filename = "www.goat.com";
		}

		if($input["sel"] == 2){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('user_id', Auth::user()->id)->get();
			
			foreach($products as $pro){
				$data .= $pro['product_id'].",".$pro['product_name'].",".$pro['brand'].",".$pro['shop_name_'].",".$pro['price_type'].",".$pro['product_price']."\n";
			}
			$filename = "it.louisvuitton.com";
		}

		if($input["sel"] == 3){
			$products = Products::where('site_url', 'https://it.burberry.com/')->where('user_id', Auth::user()->id)->get();
			
			foreach($products as $pro){
				$data .= $pro['product_id'].",".$pro['product_name'].",".$pro['brand'].",".$pro['shop_name_'].",".$pro['price_type'].",".$pro['product_price']."\n";
			}
			$filename = "it.burberry.com";
		}
				
		if($input["sel"] == 4){
			$products = Products::where('site_url', 'https://www.dior.com/')->where('user_id', Auth::user()->id)->get();
			
			foreach($products as $pro){
				$data .= $pro['product_id'].",".$pro['product_name'].",".$pro['brand'].",".$pro['shop_name_'].",".$pro['price_type'].",".$pro['product_price']."\n";
			}
			$filename = "www.dior.com";
		}
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename."_".date("Y-m-d").'.csv"');
		echo $data; exit();
	}

	public function burberry(Request $request){
	
		$user = Auth::user();
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://it.burberry.com/')->where('user_id', Auth::user()->id)->latest()->paginate(10);
	
		if(!empty($_REQUEST['skeyword']) && $_REQUEST['skeyword'] != ""){
			$products = Products::where('site_url', 'https://it.burberry.com/')->where('product_name', 'LIKE', "%{$_REQUEST['skeyword']}%")->where('user_id', Auth::user()->id)->latest()->paginate(10);
		}
		if(empty($_REQUEST['skeyword']))$_REQUEST['skeyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
        
		return view('mypage.burberry', ['user' => $user, 'products'=>$products, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'skeyword'=>$_REQUEST['skeyword']]);
	
	}

	public function dior(){
		$user = Auth::user();
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.dior.com/')->where('user_id', Auth::user()->id)->latest()->paginate(10);
		if(!empty($_REQUEST['skeyword']) && $_REQUEST['skeyword'] != ""){
			$products = Products::where('site_url', 'https://www.dior.com/')->where('product_name', 'LIKE', "%{$_REQUEST['skeyword']}%")->where('user_id', Auth::user()->id)->latest()->paginate(10);
		}
		if(empty($_REQUEST['skeyword']))$_REQUEST['skeyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
        
		return view('mypage.dior', ['user' => $user, 'products'=>$products, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'skeyword'=>$_REQUEST['skeyword']]);
	}
	
	public function itemSave(Request $request) {
		$res = $request->all();

		$res["user_id"] = Auth::user()->id;
		
		$common_id = Item::select('id')->where('id', $res["sel"])->where('user_id', Auth::user()->id)->get();

		$row = [];
		if($res["ec_kind"] == "yahoo"){
			$row["y_manager_true"] = $res["manager_true"];
			$row["user_id"] = Auth::user()->id;
		}else{
			$row["r_item_url"] = $res["item_url"];
			$row["r_tax_true"] = $res["tax_true"];
			$row["r_manager_true"] = $res["manager_true"];
			$row["user_id"] = Auth::user()->id;
		}

		if(count($common_id) > 0){			
			$sel = $res["sel"];
			Item::where("id", $sel)->update($row);
			$sel = Item::where("id", $sel)->get();
			echo json_encode($sel);
		}else{			
			$sel = Item::create($row);
			$sel = Item::where("id", $sel["id"])->get();
			echo json_encode($sel);
		}
	}
	
}
