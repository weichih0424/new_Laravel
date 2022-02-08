@extends('frontend/home')
@section("center")
<div class="mvims">
    @foreach($mvims as $mv)
    <div class="mv">
        <img src="{{asset('storage/'.$mv->img)}}" alt="">
    </div>
    @endforeach
</div>
<div class="newslist">
    <div class="bg-yellow-200 text-gray-500 py-2 pl-2">
    最新消息區
    @isset($more)
    <div class="more float-right mr-2 text-blue-400 hover:text-blue-200"><a href="{{$more}}">More...</a></div>
    @endisset
    </div>
    <ul class="">
        @foreach($news as $key=>$new)
        <li class="news relative mx-4 my-1.5">{{$key+1}}. {{mb_substr($new->text,0,20,'utf8')}}...
            <div class=" border bg-yellow-200 p-4 opacity-80 absolute right-0 -top-2/3 hidden whitespace-pre-wrap">{{$new->text}}</div>
        </li>
        @endforeach
    </ul>
</div>
@endsection
