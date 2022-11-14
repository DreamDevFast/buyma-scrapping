<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ExhibitSetting;
use App\Models\ExSetting;
use App\Models\Brands;
use App\Models\MngMode;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/activate';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => 'logout',
        ]);
    }

    public function index($role = 'worker')
    {
        return view('auth.register')->with(['role' => $role]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:30|confirmed',
                'password_confirmation' => 'required|same:password',
                'family_name' => 'required', 
            ],
            [
                'email.required' => 'メールフィールドは必須です。',
                'email.unique' => 'メールはすでに取られています。',
                'email.email' => 'メールは有効なメールアドレスである必要があります。',
                'email.max' => '電子メールは255文字を超えてはなりません。',

                'password.required' => 'パスワードフィールドは必須です。',
                'password.min' => 'パスワードは6文字以上である必要があります。',
                'password.max' => 'パスワードは30文字以内にする必要があります。',
                'password.confirmed' => 'パスワードの確認が一致しません。',

                'password_confirmation.required' => 'パスワード確認フィールドは必須です。',
                'password_confirmation.same' => 'パスワードの確認とパスワードは一致している必要があります。',

                'family_name.required' => '名前フィールドは必須です。',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function register(Request $request)
    {
	$defaultComment = "【商品説明】\n〇人気ブランドの在庫は変動が激しいため、ご購入前にお問い合わせより在庫の確認をお願い致します。\n〇商品は送料込みです。\n〇ご購入手続き後のキャンセル・返品・交換は原則として対応いたしかねます。\n【発送ついてのお知らせ】\n〇購入手続き完了後１０〜１８日で前後で発送。\n (商品状態により希に発送が遅れることがありますが、その際はご連絡いたしますので予めご了承お願いします。)\n【出品者コメント】\n〇人気ブランドのため、ご購入前にお問い合わせより在庫の確認をお願い致します。\n〇正規品及び本物鑑定済みのショップでのみ商品を買い付けしております。\n〇新品・未使用のみ販売致しております。\n〇こちらの商品は買付先にて新品保証、鑑定済みです。ただし、買付先の規定でもともと商品に付属しているブランドタグや説明書などの付属品が同梱されない場合があることを事前にご了承ください。\n【ショップからのお願い】\n〇人気ブランドの在庫は変動が激しいため、ご購入前にお問い合わせより在庫の確認をお願い致します。\n 在庫確認せずにご購入され在庫切れの際は「お客様都合」でのキャンセルとさせて頂きますことを\n 予めご了承お願いします。\n〇在庫のご用意はありますが、完売の場合やむをえずご注文をキャンセルさせて頂くことがありますのでご了承お願いします。\n〇丁寧に検品・梱包いたしますが、輸送中に箱に多少の汚れが残る場合がございますので、BUYMA補償制度あんしんプラスへのお申し込みもご検討ください。";
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
//$s = ExSetting::create(['user_id' => 20, 'commission' => 7, 'comment' => 'ddddd']);
  //      $s->save();

	$s = ExhibitSetting::create(['user_id' => $user->id, 'commission' => 7, 'comment' => $defaultComment]);
        $s->save();

        Auth::login($user);

        return redirect()->route('welcome');
    }

    protected function create(array $data)
    {
       
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'producer';
        $user = User::create($data);

        $user->save();

        return $user;
    }

}
