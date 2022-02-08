@extends('frontend/home')
@section("center")
<h5 class="text-center py-2 border-b">更多最新消息</h5>
<ul class="">
        @foreach($news as $key=>$new)
        <li class="news relative mx-4 my-1.5">{{$key+1}}. {{mb_substr($new->text,0,20,'utf8')}}...
            <div class=" border bg-yellow-200 p-4 opacity-80 absolute right-0 -top-2/3 hidden whitespace-pre-wrap">{{$new->text}}</div>
        </li>
        @endforeach
    </ul>
{{$news->links()}} 
<!-- 執行分頁功能 -->
@endsection