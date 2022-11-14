<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Products;
use App\Models\ExhibitSetting;
use App\Models\Brands;
use App\Models\User;
use App\Models\Item;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{  
	public $amazon_category_array = array();

	public function index() {
		$user = Auth::user();
		if(empty($_REQUEST['keyword']))$_REQUEST['keyword'] = "";
		if(empty($_REQUEST['now_page']))$_REQUEST['now_page'] = 1;
		return view('mypage.dashboard', ['user' => $user, 'keyword'=>$_REQUEST['keyword'], 'now_page'=>$_REQUEST['now_page']]);
	}
	public function goatpage(){
		$user = Auth::user();
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.goat.com/')->paginate(10);
		error_log('goat');
		error_log($products);
		if(!empty($_REQUEST['keyword']) && $_REQUEST['keyword'] != ""){
			$products = Products::where('site_url', 'https://www.goat.com/')->where('product_name', 'LIKE', "%{$_REQUEST['keyword']}%")->paginate(10);
		}
		if(empty($_REQUEST['keyword']))$_REQUEST['keyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
        
		return view('mypage.goatpage', ['user' => $user, 'products'=>$products, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'keyword'=>$_REQUEST['keyword']]);
	}


	public function louipage(Request $request){
		$user = Auth::user();
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://it.louisvuitton.com/');
		$query_items = [$keyword, $min, $max];
		$operatiors = ['include', '>=', '<='];
		$fields = ['', 'product_price', 'product_price'];

		for ($i = 0; $i < 3; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'include') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
        error_log($request['min']);
		return view('mypage.louipage', ['user' => $user, 'products'=>$products, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	}

	public function chanel(Request $request){
		$user = Auth::user();
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.chanel.com/');
		$query_items = [$keyword, $min, $max];
		$operatiors = ['include', '>=', '<='];
		$fields = ['', 'product_price', 'product_price'];

		for ($i = 0; $i < 3; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'include') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
        error_log($request['min']);
		return view('mypage.chanel', ['user' => $user, 'products'=>$products, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	}

	public function balenciaga(Request $request){
		$user = Auth::user();
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.balenciaga.com/');
		$query_items = [$keyword, $min, $max];
		$operatiors = ['include', '>=', '<='];
		$fields = ['', 'product_price', 'product_price'];

		for ($i = 0; $i < 3; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'include') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
        error_log($request['min']);
		return view('mypage.balenciaga', ['user' => $user, 'products'=>$products, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	}

	public function givenchy(Request $request){
		$user = Auth::user();
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.givenchy.com/');
		$query_items = [$keyword, $min, $max];
		$operatiors = ['include', '>=', '<='];
		$fields = ['', 'product_price', 'product_price'];

		for ($i = 0; $i < 3; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'include') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
        error_log($request['min']);
		return view('mypage.givenchy', ['user' => $user, 'products'=>$products, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	}
	
	public function changepass(){
		$user = Auth::user();
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://it.louisvuitton.com/')->paginate(10);
	
		if(!empty($_REQUEST['keyword']) && $_REQUEST['keyword'] != ""){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('product_name', 'LIKE', "%{$_REQUEST['keyword']}%")->paginate(10);
		}
		if(empty($_REQUEST['keyword']))$_REQUEST['keyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
		return view('mypage.changepass', ['user' => $user, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'keyword'=>$_REQUEST['keyword']]);
	}

	public function confirm_password(Request $request)
	{
		$user_data = json_decode($request['postData']);
		$user = User::find(Auth::user()->id);
		$password = $user_data->password;

		if (!Hash::check($password, $user->password)) {
			return true;
		}
	}

	public function change_password(Request $request)
	{
		$newPwd = $request['postData'];
		$user = User::find(Auth::user()->id);
		$user->forceFill([
			'password' => Hash::make($newPwd),
		])->save();
	}
	public function changeinfo(Request $request)
	{
		$user = Auth::user();
		return view('mypage.changeinfo', ['user' => $user]);
	}

	public function change_userInfo(Request $request)
	{
		$user_info = json_decode($request['postData']);
		$user = User::find(Auth::user()->id);
		$user->family_name = $user_info->name;
		$user->email = $user_info->email;
		$user->save();
	}

	public function changebuymainfo(Request $request)
	{
		$user = User::find(Auth::user()->id);
		return view('mypage.changebuymainfo', ['user' => $user]);
	}

	public function change_buyma_info(Request $request)
	{
		$buyma_info = json_decode($request['postData']);
		$user = User::find(Auth::user()->id);
		$user->buyma_id = $buyma_info->id;
		$user->buyma_pwd = $buyma_info->pwd;
		$user->save();
		return;
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
		$exhibitsetting = ExhibitSetting::where('user_id', $user->id)->first();
		$products = Products::where('site_url', 'https://it.louisvuitton.com/')->paginate(10);
	
		if(!empty($_REQUEST['keyword']) && $_REQUEST['keyword'] != ""){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->where('product_name', 'LIKE', "%{$_REQUEST['keyword']}%")->paginate(10);
		}
		if(empty($_REQUEST['keyword']))$_REQUEST['keyword'] = "";
        if(empty($_REQUEST['page']))$_REQUEST['page'] = 1;
        $end = $products->lastPage();
		return view('mypage.exhibitsettings', ['exhibitsettings' => $exhibitsetting, 'now_page'=>$_REQUEST['page'], 'end_page'=>$end, 'keyword'=>$_REQUEST['keyword']]);
	}

	public function count(request $request){
		$cnt = 0;
		$input = $request->all();
		if($input["sel"] == 1){
			$products = Products::where('site_url', 'https://www.goat.com/')->get();
			$cnt = count($products);
		}

		if($input["sel"] == 2){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->get();
			$cnt = count($products);
		}

		if($input["sel"] == 3){
			$products = Products::where('site_url', 'https://it.burberry.com/')->get();
			$cnt = count($products);
		}

		if($input["sel"] == 4){
			$products = Products::where('site_url', 'https://www.dior.com/')->get();
			$cnt = count($products);
		}
		return $cnt;
	}

	public function csv_down(request $request){
		$input = $request->all();
		$data = "";
		$filename = "";
		if($input["sel"] == 1){
			$products = Products::where('site_url', 'https://www.goat.com/')->get();
			
			foreach($products as $pro){
				$data .= $pro['product_id'].",".$pro['product_name'].",".$pro['brand'].",".$pro['shop_name_'].",".$pro['price_type'].",".$pro['product_price']."\n";
			}

			$filename = "www.goat.com";
		}

		if($input["sel"] == 2){
			$products = Products::where('site_url', 'https://it.louisvuitton.com/')->get();
			
			foreach($products as $pro){
				$data .= $pro['product_id'].",".$pro['product_name'].",".$pro['brand'].",".$pro['shop_name_'].",".$pro['price_type'].",".$pro['product_price']."\n";
			}
			$filename = "it.louisvuitton.com";
		}

		if($input["sel"] == 3){
			$products = Products::where('site_url', 'https://it.burberry.com/')->get();
			
			foreach($products as $pro){
				$data .= $pro['product_id'].",".$pro['product_name'].",".$pro['brand'].",".$pro['shop_name_'].",".$pro['price_type'].",".$pro['product_price']."\n";
			}
			$filename = "it.burberry.com";
		}
				
		if($input["sel"] == 4){
			$products = Products::where('site_url', 'https://www.dior.com/')->get();
			
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
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://it.burberry.com/');
		$query_items = [$keyword, $min, $max];
		$operatiors = ['include', '>=', '<='];
		$fields = ['', 'product_price', 'product_price'];

		for ($i = 0; $i < 3; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'include') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
        error_log($request['min']);
		return view('mypage.burberry', ['user' => $user, 'products'=>$products, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	
	}

	public function dior(Request $request){
		$user = Auth::user();
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.dior.com/');
		$query_items = [$keyword, $min, $max];
		$operatiors = ['include', '>=', '<='];
		$fields = ['', 'product_price', 'product_price'];

		for ($i = 0; $i < 3; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'include') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
        error_log($request['min']);
		return view('mypage.dior', ['user' => $user, 'products'=>$products, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	}

	public function gucci(Request $request){
		$user = Auth::user();
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		//::latest()->paginate(10);
		$products = Products::where('site_url', 'https://www.gucci.com/');
		$query_items = [$keyword, $min, $max];
		$operatiors = ['include', '>=', '<='];
		$fields = ['', 'product_price', 'product_price'];

		for ($i = 0; $i < 3; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'include') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
        error_log($request['min']);
		return view('mypage.gucci', ['user' => $user, 'products'=>$products, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	}

	public function findandsell(Request $request) {
		$user = Auth::user();
		$keyword = $request['keyword'];
		$min = $request['min'];
		$max = $request['max'];
		$queryBrands = $request['brands'];
		//::latest()->paginate(10);
		$products = Products::where('products.id', '>', -1);
		$query_items = [$keyword, $min, $max, $queryBrands];
		$operatiors = ['included', '>=', '<=', 'includes'];
		$fields = ['', 'product_price', 'product_price', 'brand'];

		for ($i = 0; $i < 4; $i++) {
			if (isset($query_items[$i])) {
				if ($operatiors[$i] == 'included') {
					$delimeter = ' ';
					$keywords = explode($delimeter, $query_items[$i]);
					foreach($keywords as $each){
						$products = $products->where(function($query) use ($each){
							 $query->where('product_name', 'like', '%' . $each . '%')
								 ->orWhere('product_comment', 'like', '%' . $each . '%');
							 });
				 	}
				}
				else if ($operatiors[$i] == 'includes') {
					$delimeter = '.';
					$brandIds = explode($delimeter, $query_items[$i]);
					if (count($brandIds) == 1 && $brandIds[0] == '-1') {

					}
					else {
						$products = $products->whereIn('brand', $brandIds);
					}
				}	
				else {
					$products = $products->where($fields[$i], $operatiors[$i], $query_items[$i]);
				}
			}
		}

		$products = $products->join('brands', 'products.brand', '=', 'brands.id')->select('products.*', 'brands.name')->paginate(10);

		if(empty($request['keyword']))$request['keyword'] = "";
        if(empty($request['page']))$request['page'] = 1;
		if(empty($request['min']))$request['min'] = '';
		if(empty($request['max']))$request['max'] = '';

        $end = $products->lastPage();
		$brands = Brands::all();
		$currentbrands = ['-1'];
		if(isset($queryBrands)) {
			$currentbrands = explode('.', $queryBrands);
		}
		error_log(count($currentbrands));
		return view('mypage.findandsell', ['user' => $user, 'products'=>$products, 'brands'=>$brands, 'currentbrands'=>$currentbrands, 'now_page'=>$request['page'], 'end_page'=>$end, 'keyword'=>$request['keyword'], 'min'=>$request['min'], 'max'=>$request['max']]);
	}
	
	public function itemSave(Request $request) {
		$res = $request->all();

		$res["user_id"] = Auth::user()->id;
		
		$common_id = Item::select('id')->where('id', $res["sel"])->get();

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
	
	public function changeExhibitSettings(Request $request) {
		$user = Auth::user();
		$commission = $request['commission'];
		$comment = $request['comment'];
		
		if (isset($commission) && isset($comment)) {
			ExhibitSetting::where('user_id', $user->id)->update(['commission' => $commission, 'comment' => $comment]);
		}
		$exhibitsetting = ExhibitSetting::where('user_id', $user->id)->first();
		error_log($exhibitsetting->comment);
		return view('mypage.exhibitsettings', ['exhibitsettings' => $exhibitsetting]);
	}

	public function admin_page(Request $request) {
		$users = User::all();
		return view('mypage.admin_page', ['users' => $users]);
	}

	public function delete_account(Request $request) {
		$id = $request->id;
		User::find($id)->delete();
	}

	public function permit_account(Request $request)
	{
		$id = $request['id'];
		$user = User::find($id);
		$user->is_permitted = $request['isPermitted'];
		$user->save();
	}
}
