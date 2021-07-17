
@extends('layout')
@section('title')
{{$chitiet_sp->tensp}}
@endsection
@section('noidung')
<!--Container-->
<hr class="my-4">
<div class="container">
    @if (Session::has('message'))
    <div class="alert alert-success mt-3" id="alert-success">
        <span>{{Session::get('message')}}</span>
    </div>
    @endif
	<div class="row">
        <div class="col-6">
<form>
    @csrf
            <div class="owl-carousel owl-theme" id="chitiet">
                @foreach ($chitiet_sp->Hinhanh as $img)
                          <div class="item"><img style="width:480px;heigth:460px;" src="{{asset ('storage/'.$img->name) }}" alt=""></div>
                @endforeach
            </div>

        </div>
        <div class="col-6">
                <input type="hidden" name="id" value="{{$chitiet_sp->id}}" id="">
                <h2>{{$chitiet_sp->tensp}}</h2>
                ________
                <h3>
                     @if ($chitiet_sp->giakm===0)
                        <p style="color: red;">{{ number_format($chitiet_sp->giaban,0,'.','.').' '.'đ' }}</p>
                    @else
                         <p><del>{{ number_format($chitiet_sp->giaban,0,'.','.').' '.'đ' }}</del></p>
                         <p style="color: red;">{{ number_format($chitiet_sp->giakm,0,'.','.').' '.'đ' }}</p>
                    @endif
                </h3>
                <div class="cate">Trạng thái:
                    @if ($total_sp==0)
                        <span class="text-warning">Hết hàng</span>
                    @else
                            <span >Còn hàng</span>
                    @endif
                </div>
                <hr>
                <div class="cate select-swap">Size:
                    @foreach($chitiet_sp->size as $value)
                    @if ($value->soluong==0)
                    <label for="size-{{$value->size}}"class="btn btn-light text-center">
                        <input type="radio" id="size-{{$value->size}}" value="{{$value->size}}" disabled >{{$value->size}}
                    </label>
                    @else
                        <label for="size-{{$value->size}}"class="btn btn-outline-dark text-center">
                            <input type="radio" id="size-{{$value->size}}" checked name="size" value="{{$value->id}}">{{$value->size}}
                        </label>
                    @endif
                    @endforeach
                </div>
                <div class="mt-3">
                    Số lượng:
                    <div class="input-group-prepend">
                            <span class="btn btn-light" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</span>
                            <input type="number" value="1" id="quanty-item" name="soluong" class="btn btn-light text-center" min="1" max="10" readonly>
                            <span class="btn btn-light"onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</span>
                    </div>
                </div>
                <div class="mt-3">
                    @if ($total_sp==0)
                        <button type="button" class="btn btn-dark" disabled >Hết hàng</button>
                    @else
                        <button type="submit" class="btn btn-dark btn-submit"> Thêm vào giỏ hàng</button>
                    @endif
                </div>
        </div>
    </form>

    </div>

    <div class="mt-5">
        <hr>
        <h2 class="text-center ">Sản phẩm liên quan</h2>
        <div class="row">
            <div class="owl-carousel owl-theme" id="lienquan">
                        @foreach($sp_lienquan as $sp)
                        <div class="productinfo text-center">
                            <a href="{{ url('chitiet-sanpham/'.$sp->id)}}" class="link">
                                @foreach ($sp->Hinhanh as $img )
                                @if ($img->avt===1)
                                     <img class="card-img-top" src="{{asset ('storage/'.$img->name) }}" alt="Card image">
                                @endif
                                @endforeach
                              <div class="card-body">
                                    @php
                                   $total=0;
                                    foreach ($sp->size as $size)
                                    {
                                        $total+=$size->soluong;
                                    }
                                        if ($total==0) {
                                            echo '<h5 class="card-title text-danger" >[HẾT HÀNG]</h5>';
                                        }
                                    @endphp
                                <h4 class="card-title">{{$sp->tensp}}</h4>
                            </a>
                                 @if ($sp->giakm===0)
                                      <p style="color: red;">{{ number_format($sp->giaban,0,'.','.').' '.'đ' }}</p>
                                  @else
                                      <p><del>{{ number_format($sp->giaban,0,'.','.').' '.'đ' }}</del></p>
                                     <p style="color: red;">{{ number_format($sp->giakm,0,'.','.').' '.'đ' }}</p>
                                  @endif
                        </div>
                </div>
                        @endforeach
            </div>
        </div>
    </div>

</div>
<!--Container-->
<script src="{{ asset ('/js/owl.carousel.min.js') }}" type="text/javascript"></script>

<script>
    $('#chitiet').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        autoplay:true,
        responsive:{
            520:{
                items:1
            },
        }
    });
    $('#lienquan').owlCarousel({
        margin:10,
        nav:true,
        autoplay:true,
        responsive:{
            460:{
                items:4
            },
        }
    });

    //them giỏ hàng
$(document).ready(function() {
        $(".btn-submit").click(function(e){
            e.preventDefault();


            var _token = $("input[name='_token']").val();
            var id = $("input[name='id']").val();
            var size = document.querySelector('input[name = "size"]:checked').value;
            var qty=$("#quanty-item").val();
            $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                     }
                });
                $.ajax({
                    url:'/them-giohang',
                    type:'POST',
                    data:{_token:_token,id:id,size:size,qty:qty},
                }).done(function(response){
                    if($.isEmptyObject(response.error)){
                        $("#total-quanty-show").empty();
                         $("#total-quanty-show").html(response.data);
                        alertify.success(response.success);
                    }
                    else{
                        alertify .alert(response.error, function(){
                            location.reload();
                    });
                    }
                });
    });
    });

 //alert thông báo
 window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove();
          });
},              3000);
</script>
@endsection




