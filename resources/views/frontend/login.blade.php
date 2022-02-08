@extends('frontend/home')
@section("center")
@if(!empty(session('error')))
<div class="w-full bg-red-300 border-red-400 border-2 text-red-900 text-center">{{session('error')}}</div>
@endif
<form action="/login" method="post">
@csrf
    <p class="text-center my-3">帳號：<input class="border-b py-2" type="text" name="acc"></p>
    <p class="text-center my-3">密碼：<input class="border-b py-2" type="text" name="pw"></p>
    <p class="text-center my-3">
    <input type="submit" value="登入" class="gray-btn hover:bg-green-200 px-4 py-2 mt-3 rounded-lg">
    <input type="reset" value="重置" class="gray-btn hover:bg-yellow-200 px-4 py-2 mt-3 rounded-lg">
    </p>
</form>
@endsection