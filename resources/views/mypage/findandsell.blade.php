@extends("layouts.mypage")
@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>探して出品する</h2>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 col-sm-12">
                            <select id="brands" name="brands[]" onchange="onSelectBrands()" multiple>
                                <option value="-1" id="option-0" {{ in_array("-1", $currentbrands) ? 'selected' : ''}}>All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}" id="option-{{$loop->index + 1}}" {{in_array($brand->id, $currentbrands) ? 'selected' : ''}}>{{$brand->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                            <input type="string" id="keyword" class="form-control" placeholder="検索キーワード入力" value="{{$keyword}}">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                            <input type="number" id="min_price" class="form-control" placeholder="最小価格入力" value="{{$min}}" min=0>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 mt-2">
                            <input type="number" id="max_price" class="form-control" placeholder="最大価格入力" value="{{$max}}" min=0>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-3 col-sm-12 mt-2">
                            <button type="button" class="btn btn-primary waves-effect w-100" onclick="find_products()">検  索</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-12 mt-2">
                            <button type="button" class="btn btn-danger waves-effect w-100" onclick="exhibit()" {{ Auth::user()->status != 'init' ? 'disabled' : '' }}>Buyma出品</button>
                        </div>
                    </div>
                </div>
            </div>
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
                                        <th data-breakpoints="xs">ブランド</th> 
                                        <th data-breakpoints="md">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td><img src="{{$product->product_img}}" width="48" alt="Product img"></td>
                                        <td style="white-space:normal"><h5>{{$product->product_name}}</h5></td>
                                        <td style="white-space:normal">
                                            <span class="text-muted">                                                 
                                                {{$product->product_comment}}                                       
                                            </span>
                                        </td>
                                        <td>¥<?=number_format($product->product_price , 0,".",",")?></td>   
                                        <td>{{$product->name}}</td>                                     
                                        <td>                                            
                                            <input type="checkbox" id="{{$product->id}}" class="product-check-box" onchange="onclickcheckbox(this, {{$product->id}})">
                                        </td>
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
                                <li class="page-item <?php if($now_page == $i)echo 'active';?>"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=$i?>"><?=$i?></a></li>
                                
                            <?php }
                            }else{
                                if($now_page < 8){
                                    for($i = 1; $i < 6; $i++){
                                        ?>
                                            <li class="page-item <?php if($now_page == $i)echo 'active';?>"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=$i?>"><?=$i?></a></li>                                            
                                    <?php } ?>
                                    
                                    <?php if($end_page >= 7){?>
                                        <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=6">...</a></li>
                                        <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($end_page)?>"><?=($end_page)?></a></li>
                                        <li class="page-item"><a class="page-link" href="./findandsell?page=<?=($now_page + 7)?>&keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>"><i class="zmdi zmdi-arrow-right"></i></a></li>
                                    <?php } else{?>
                                        <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=6?>">6</a></li>
                                        <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=7?>">7</a></li>
                                    <?php }?>

                                    <?php
                                }else if($now_page > $end_page - 7){
                                    ?>
                                    <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($end_page - 7)?>"><i class="zmdi zmdi-arrow-left"></i></a></li>
                                    <?php
                                    for($i = $end_page - 6; $i < $end_page + 1; $i++){
                                        ?>
                                            <li class="page-item <?php if($now_page == $i)echo 'active';?>"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=$i?>"><?=$i?></a></li>                                            
                                    <?php } ?>                                    
                                    <?php
                                }else{?>

                                    <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($now_page - 7)?>"><i class="zmdi zmdi-arrow-left"></i></a></li>
                                    
                                    <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=1">1</a></li>
                                    <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($now_page-2)?>">...</a></li>                                            
                                    <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($now_page-1)?>"><?=($now_page-1)?></a></li>
                                    <li class="page-item active"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($now_page)?>"><?=($now_page)?></a></li>
                                    <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($now_page+1)?>"><?=($now_page+1)?></a></li>  
                                    <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($now_page+2)?>">...</a></li>                                      
                                    
                                    <?php if($end_page >= ($now_page + 3)){?>
                                        <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($end_page)?>"><?=($end_page)?></a></li>
                                        <li class="page-item"><a class="page-link" href="./findandsell?page=<?=($now_page + 7)?>&min=<?=$min?>&max=<?=$max?>&keyword=<?=$keyword?>"><i class="zmdi zmdi-arrow-right"></i></a></li>
                                    <?php } else{?>
                                        <li class="page-item"><a class="page-link" href="./findandsell?keyword=<?=$keyword?>&min=<?=$min?>&max=<?=$max?>&page=<?=($now_page+3)?>"><?=($now_page+3)?></a></li>
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
@endsection
@push('scripts')
<script>
    $( document ).ready(function() {
        let checkedIds = localStorage.getItem('checkedIds')
        $('.product-check-box').each(function (){
            $(this).attr('checked', checkedIds.includes(this.id))
        })
    })
    function find_products () {
        let keyword = $("#keyword").val(), min = $("#min_price").val(), max = $("#max_price").val(), brands = $('#brands').val();
        let queries = { keyword, min, max }, url = './findandsell', querystring = '';
        let keys = Object.keys(queries);
        for (let i = 0; i < keys.length; i++) {
            if (queries[keys[i]] !== '') {
                querystring += `${keys[i]}=${queries[keys[i]]}&`
            }
        }
        if (querystring !== '') {
            url += '?' + querystring;
            url = url.slice(0, -1)
        }
        
        if (brands.length !== 0) {
            url += '&brands=' + brands.join('.')
            localStorage.setItem('checkedIds', '')
            document.location.href = url
        }
    }
    var selectedValues = []
    function onSelectBrands () {
        let currentselectedValues = $('#brands').val();
        if (!selectedValues.includes('-1')) {
            if (currentselectedValues.includes('-1')) {
                $('.dropdown-menu.inner li').attr('class', '')
                $('.dropdown-menu.inner li:nth-of-type(1)').attr('class', 'selected')
                $('#brands').val('-1')
                selectedValues = ['-1']
            }
            else {
                if (currentselectedValues.length === $('.dropdown-menu.inner li').length -1) {
                    $('.dropdown-menu.inner li').attr('class', '')
                    $('.dropdown-menu.inner li:nth-of-type(1)').attr('class', 'selected')
                    $('#brands').val('-1')
                    selectedValues = ['-1']
                }
                else {
                    selectedValues = currentselectedValues
                }
            }
        }
        else {
            $('.dropdown-menu.inner li:nth-of-type(1)').attr('class', '')
            selectedValues = []
            currentselectedValues.forEach(value => {
                if (value !== '-1') selectedValues.push(value)
            })
            $('#brands').val(selectedValues)
        }
        
    }

    function onclickcheckbox(ele, product_id) {
        if (ele.checked) {
            let checkedIds = localStorage.getItem('checkedIds')
            if (checkedIds === null || checkedIds === '') {
                checkedIds = product_id
            }
            else {
                checkedIds += '.' + product_id
            }
            localStorage.setItem('checkedIds', checkedIds)
        }
        else {
            let checkedIds = localStorage.getItem('checkedIds')
            let ids = checkedIds.split('.')
            let index = ids.findIndex(id => parseInt(id) === product_id)
            ids.splice(index, 1)
            checkedIds = ids.join('.')
            localStorage.setItem('checkedIds', checkedIds)
        }
    }

    function exhibit() {
        let checkedIds = localStorage.getItem('checkedIds')
        if (checkedIds === null || checkedIds === '') {
            alert('出品する商品を選択してください')
            return
        }
        else {
            let ids = checkedIds.split('.')
            $.ajax({
                url: '{{env('API_URL')}}/api/v1/exhibit',
                type: 'post',
                data: {
                    user_id: '{{Auth::user()->id}}',
                    ids: ids
                },
                success: function() {
                    window.location.reload()
                }
            });
            localStorage.setItem('checkedIds', '')
        }
    }
</script>
@endpush
