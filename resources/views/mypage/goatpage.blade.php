@extends("layouts.mypage")
@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>GOATの商品リスト</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Aero</a></li>
                        <li class="breadcrumb-item">商品管理</li>
                        <li class="breadcrumb-item active">GOATの商品リスト</li>  
                        <!-- <span class="badge badge-info mr-2" id="cnt">「すべて:11,000つ」</span>                         -->
                    </ul>                    
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                    <button class="btn btn-warning btn-icon float-right" type="button" title="CSVダウンロード" onclick="csv_down(1)"><i class="zmdi zmdi-download"></i></button>
                    <!-- <button class="btn btn-warning btn-icon float-right" type="button" title="出品"  onclick="exhibit_goat_product()" php if(Auth::user()->status != 'init')echo 'disabled';?>><i class="zmdi zmdi-upload"></i></button> -->
                    <button class="btn btn-success btn-icon float-right" type="button" title="商品追加"  data-toggle="modal" data-target="#defaultModal" <?php if(Auth::user()->status != 'init')echo 'disabled';?>><i class="zmdi zmdi-plus"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-hover product_item_list c_table theme-color mb-0">
                                <thead>
                                    <tr>
                                        <th>画像</th>
                                        <th>商品名</th>
                                        <th data-breakpoints="md">商品詳細</th>
                                        <th data-breakpoints="xs">商品価格</th>  
                                        <!--<th data-breakpoints="md">Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td><img src="{{$product->product_img}}" width="48" alt="Product img"></td>
                                        <td style="white-space:inherit"><h5>{{$product->product_name}}</h5></td>
                                        <td>
                                            <span class="text-muted">                                                 
                                                <div style="display:flex; align-items: center;"> 
                                                    <div style="background-color: {{$product->size_color}};
                                                        border: #666 1px solid;
                                                        width: 15px; margin-right:3px;
                                                        height: 15px;
                                                        border-radius:15px" title="{{$product->size_color}}">
                                                    </div>
                                                     {{$product->size_color}}
                                                </div>
                                                <div><span class="ti-layout-grid2" title="カテゴリ"></span> {{$product->category}}</div>
                                                <div><span class="ti-apple" title="ブランド　"></span> {{$product->brand}}</div>
                                                <div><span class="ti-timer" title="購入期限"></span> {{$product->deadline}}</div>
                                                <div><span class="ti-home" title="買付先ショップ名"></span> {{$product->shop_name_}}</div>                                       
                                            </span>
                                        </td>
                                        <td>￥<?=number_format($product->product_price, 0,".",",")?></td>   
                                        <!--<td>                                            
                                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                        </td>-->
                                    </tr>
                                @endforeach           
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php //var_export($end_page)?>
                    <div class="card">
                        <div class="body"> 
                            <ul class="pagination pagination-primary m-b-0">
                            <?php
                            if($end_page < 8){
                                for($i = 1; $i < $end_page; $i++){
                            ?>
                                <li class="page-item <?php if($now_page == $i)echo 'active';?>"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=$i?>"><?=$i?></a></li>
                                
                            <?php }
                            }else{
                                if($now_page < 8){
                                    for($i = 1; $i < 6; $i++){
                                        ?>
                                            <li class="page-item <?php if($now_page == $i)echo 'active';?>"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=$i?>"><?=$i?></a></li>                                            
                                    <?php } ?>
                                    
                                    <?php if($end_page >= 7){?>
                                        <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=6">...</a></li>
                                        <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($end_page)?>"><?=($end_page)?></a></li>
                                        <li class="page-item"><a class="page-link" href="./goatpage?page=<?=($now_page + 7)?>&keyword=<?=$keyword?>"><i class="zmdi zmdi-arrow-right"></i></a></li>
                                    <?php } else{?>
                                        <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=6?>">6</a></li>
                                        <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=7?>">7</a></li>
                                    <?php }?>

                                    <?php
                                }else if($now_page > $end_page - 7){
                                    ?>
                                    <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($end_page - 7)?>"><i class="zmdi zmdi-arrow-left"></i></a></li>
                                    <?php
                                    for($i = $end_page - 6; $i < $end_page + 1; $i++){
                                        ?>
                                            <li class="page-item <?php if($now_page == $i)echo 'active';?>"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=$i?>"><?=$i?></a></li>                                            
                                    <?php } ?>                                    
                                    <?php
                                }else{?>

                                    <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($now_page - 7)?>"><i class="zmdi zmdi-arrow-left"></i></a></li>
                                    
                                    <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=1">1</a></li>
                                    <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($now_page-2)?>">...</a></li>                                            
                                    <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($now_page-1)?>"><?=($now_page-1)?></a></li>
                                    <li class="page-item active"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($now_page)?>"><?=($now_page)?></a></li>
                                    <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($now_page+1)?>"><?=($now_page+1)?></a></li>  
                                    <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($now_page+2)?>">...</a></li>                                      
                                    
                                    <?php if($end_page >= ($now_page + 3)){?>
                                        <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($end_page)?>"><?=($end_page)?></a></li>
                                        <li class="page-item"><a class="page-link" href="./goatpage?page=<?=($now_page + 7)?>&keyword=<?=$keyword?>"><i class="zmdi zmdi-arrow-right"></i></a></li>
                                    <?php } else{?>
                                        <li class="page-item"><a class="page-link" href="./goatpage?keyword=<?=$keyword?>&page=<?=($now_page+3)?>"><?=($now_page+3)?></a></li>
                                    <?php }?>
                            <?php 
                                }
                            }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Default Size -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">検索条件設定画面</h4>
            </div>
            <div class="modal-body"> 
                <div class="row" style="margin:5px 5px 20px 5px">
                    <div class="col-lg-4 col-md-4 col-sm-4"> ジャンル</div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <select class="form-control show-tick" id="category" name="category">
                            <option value="0">バスケットボール</option>
                            <option value="1">ブーツ</option>
                            <option value="2">子供用</option>
                            <option value="3">クリート</option>
                            <option value="4">ライフスタイル</option>
                            <option value="5">ランニング</option>
                            <option value="6">サンダル</option>
                            <option value="7">スケートボード</option>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin:5px 5px 20px 5px">
                    <div class="col-lg-4 col-md-4 col-sm-4"> ジャンル</div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <select class="form-control show-tick" id="brand" name="brand">
                            <option value="0">1017 ALYX 9SM</option>
                            <option value="1">11 by Boris Bidjan Saberi</option>
                            <option value="2">361 Degrees</option>
                            <option value="3">Acne Studios</option>
                            <option value="4">adidas</option>
                            <option value="5">Air Jordan</option>
                            <option value="6">Alexander McQueen</option>
                            <option value="7">Alife</option>
                            <option value="8">Ambush</option>
                            <option value="9">Amiri</option>
                            <option value="10">AND1</option>
                            <option value="11">Anta</option>
                            <option value="12">a.p.c.</option>
                            <option value="13">ASICS</option>
                            <option value="14">Balenciaga</option>
                            <option value="15">Balmain</option>
                            <option value="16">BAPE</option>
                            <option value="17">Big Baller Brand</option>
                            <option value="18">Billionaire Boys Club</option>
                            <option value="19">Birkenstock</option>
                            <option value="20">Bottega Veneta</option>
                            <option value="21">Brandblack</option>
                            <option value="22">Brooks</option>
                            <option value="23">Burberry</option>
                            <option value="24">Buscemi</option>
                            <option value="25">Calvin Klein</option>
                            <option value="26">Casbia</option>
                            <option value="27">CELINE</option>
                            <option value="28">Champion</option>
                            <option value="29">Chanel</option>
                            <option value="30">Chloé</option>
                            <option value="31">Christian Louboutin</option>
                            <option value="32">Circa</option>
                            <option value="33">CLAE</option>
                            <option value="34">Clarks</option>
                            <option value="35">Clearweather</option>
                            <option value="36">Collegium</option>
                            <option value="37">Comme des Garçons</option>
                            <option value="38">Common Projects</option>
                            <option value="39">Converse</option>
                            <option value="40">Courrèges</option>
                            <option value="41">Creative Recreation</option>
                            <option value="42">Crocs</option>
                            <option value="43">Curry Brand</option>
                            <option value="44">Dada</option>
                            <option value="45">Danner</option>
                            <option value="46">Dc</option>
                            <option value="47">Diadora</option>
                            <option value="48">Diamond Supply Co.</option>
                            <option value="49">DIDU</option>
                            <option value="50">Dior</option>
                            <option value="51">dolce & gabbana</option>
                            <option value="52">dr. martens</option>
                            <option value="53">Ellesse</option>
                            <option value="54">Etonic</option>
                            <option value="55">Ewing</option>
                            <option value="56">Fear of God</option>
                            <option value="57">Fear of God Essentials</option>
                            <option value="58">Fendi</option>
                            <option value="59">Fila</option>
                            <option value="60">Filling Pieces</option>
                            <option value="61">Fracap</option>
                            <option value="62">Fred Perry</option>
                            <option value="63">Giuseppe Zanotti</option>
                            <option value="64">Givenchy</option>
                            <option value="65">Golden Goose</option>
                            <option value="66">Gucci</option>
                            <option value="67">Hender Scheme</option>
                            <option value="68">Heron Preston</option>
                            <option value="69">Hoka One One</option>
                            <option value="70">HUF</option>
                            <option value="71">Hummel Hive</option>
                            <option value="72">Isabel Marant</option>
                            <option value="73">Jimmy Choo</option>
                            <option value="74">John Geiger</option>
                            <option value="75">Junya Watanabe</option>
                            <option value="76">Just Don</option>
                            <option value="77">K Swiss</option>
                            <option value="78">KangaROOS</option>
                            <option value="79">Karhu</option>
                            <option value="80">Lakai</option>
                            <option value="81">Lanvin</option>
                            <option value="82">Le Coq Sportif</option>
                            <option value="83">li-ning</option>
                            <option value="84">Loewe</option>
                            <option value="85">Louis Vuitton</option>
                            <option value="86">Lugz</option>
                            <option value="87">Mad Foot</option>
                            <option value="88">Maison Margiela</option>
                            <option value="89">Marine Serre</option>
                            <option value="90">Marni</option>
                            <option value="91">MCM</option>
                            <option value="92">MCQ</option>
                            <option value="93">Mercer Amsterdam</option>
                            <option value="94">Merrell</option>
                            <option value="95">Midnight Studios</option>
                            <option value="96">Mizuno</option>
                            <option value="97">Moncler</option>
                            <option value="98">MSCHF</option>
                            <option value="99">New Balance</option>
                            <option value="100">Nike</option>
                            <option value="101">Off-White</option>
                            <option value="102">ON</option>
                            <option value="103">Onitsuka Tiger</option>
                            <option value="104">Opening Ceremony</option>
                            <option value="105">Osiris</option>
                            <option value="106">Other</option>
                            <option value="107">Palm Angels</option>
                            <option value="108">PF Flyers</option>
                            <option value="109">Polo Ralph Lauren</option>
                            <option value="110">Pony</option>
                            <option value="111">Prada</option>
                            <option value="112">Puma</option>
                            <option value="113">Raf Simons</option>
                            <option value="114">Reebok</option>
                            <option value="115">Rhude</option>
                            <option value="116">Rick Owens</option>
                            <option value="117">Royal Elastics</option>
                            <option value="118">Saint Laurent</option>
                            <option value="119">Salomon</option>
                            <option value="120">Sandal Boyz</option>
                            <option value="121">Saucony</option>
                            <option value="122">Starbury</option>
                            <option value="123">Stella McCartney</option>
                            <option value="124">Straye</option>
                            <option value="125">Suicoke</option>
                            <option value="126">Superga</option>
                            <option value="127">Supra</option>
                            <option value="128">Supreme</option>
                            <option value="129">Tas</option>
                            <option value="130">The Hundreds</option>
                            <option value="131">The North Face</option>
                            <option value="132">Timberland</option>
                            <option value="133">Tommy Hilfiger</option>
                            <option value="134">Ubiq</option>
                            <option value="135">Ugg</option>
                            <option value="136">Umbro</option>
                            <option value="137">Undefeated</option>
                            <option value="138">Under Armour</option>
                            <option value="139">Valentino</option>
                            <option value="140">Vans</option>
                            <option value="141">Veja</option>
                            <option value="142">Versace</option>
                            <option value="143">Vetements</option>
                            <option value="144">Visvim</option>
                            <option value="145">Yeezy</option>
                            <option value="146">Yohji Yamamoto</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="row" style="margin:5px 5px 5px 5px">
                    <div class="col-lg-4 col-md-4 col-sm-4"> ワード</div>
                    <div class="col-lg-8 col-md-8 col-sm-8"><input type="text" class="form-control" id="keyword" name="keyword" value="=$keyword?>"></div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect" onclick="add_goat_products()">追加</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">キャンセル</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function add_goat_products(){
        $("#defaultModal").modal('hide');
        let min = $("#min_price").val(), max = $("#max_price").val(), category = $('#category').val(), brand = $('#brand').val();
        $.ajax({
            url: '{{env('API_URL')}}/api/v1/goats/get_info?sel={{Auth::user()->id}}',
            type: 'get',
            data: {
                category: category,
                brand: brand
            },
            success: function() {
            }
        });
        // let queries = { min, max }, url = './goats', querystring = '';
        // let keys = Object.keys(queries);
        // for (let i = 0; i < keys.length; i++) {
        //     if (queries[keys[i]] !== '') {
        //         querystring += `${keys[i]}=${queries[keys[i]]}&`
        //     }
        // }
        // if (querystring !== '') {
        //     url += '?' + querystring;
        //     url = url.slice(0, -1)
        // }

        document.location.href = './goatpage'
    }

    function exhibit_goat_product(){
        $.ajax({
            url: '{{env('API_URL')}}/api/v1/goats',
            type: 'post',
            data: {
                user_id: '{{Auth::user()->id}}'
            },
            success: function() {
                window.location.reload()
            }
        });
    }
</script>
@endpush
