@extends('layout')
@section('dangnhap')
<div class="container text-center" >
<br>
<h2 class="title ">ĐĂNG NHẬP</h2>
<br>
<div class="row "> 
  <div class="col-md-4 "></div>
  <div class="col-md-4 ">
  <form action="{{ url('/dangnhap') }}" method="post">
  {{ csrf_field() }}
    @if(Session::has('thongbao'))
    <div class="text-danger">{{Session::get('thongbao')}} </div>
    @endif
    <div class="form-group">
    <input type="email" class="form-control" id="email" placeholder="Email của bạn" name="email">
        @if($errors->has('email'))
        <div class="text-danger">
        {{$errors->first('email')}}
        </div>
        @endif
    </div>
    <div class="form-group" >
    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password">
        @if($errors->has('password'))
        <div class="text-danger">
        {{$errors->first('password')}}
        </div>
        @endif
    </div>
    
    <button type="submit" class="btn btn-secondary"  >Đăng nhập</button>
   
  
  </form>
    <div>
    <a class="btn btn-link" href="#"> Quên mật khẩu?</a>
    </div>
    <br>
    <div>
    <a class="btn btn-outline-success" href="{{ url('/dangki') }}" >
    Đăng kí thành viên mới</a>
    </div>
    
   
  </div>
</div>
</div>
   


@endsection


