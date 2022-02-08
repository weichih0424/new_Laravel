@extends("layouts/layout")

@section("main")
<div class="menu col-span-3">
    <div class="menu col-span-3 border h-full ">
        @isset($menus)
        <div class="text-center w-9/12 mx-auto border-b p-3 mb-3">主選單區</div>
        @foreach($menus as $menu)
        <div class="menu_sub text-center text-sm">
            <div class="option p-3">
                <a href="{{ $menu->href }}" class="block">{{ $menu->text }}</a>
                @isset($menu->subs)
                <div class="sublist w-full">
                    @foreach($menu->subs as $sub)
                    <div class="subs p-3">
                        <a href="{{ $sub->href }}" class="block">{{ $sub->text }}</a>
                    </div>
                    @endforeach
                </div>
                @endisset
            </div>
        </div>
        @endforeach
        @endisset
        <div class="total border-t border-b text-center my-2">
        <div>訪客人數
            <hr>
        </div>
        <div class="h-full text-green-500 text-lg text-center">{{ $total }}</div>
    </div>
    </div>
</div>
<div class="main_contant col-span-6">
    @isset($ads)
    <div class="ads">
        <marquee behavior="" direction="">{{$ads}}</marquee>
    </div>
    @endisset
    @yield('center')
</div>
<div class="right_side col-span-3 border">
    <div class="w-full">
    <!-- auth/已驗證使用者 guest/未驗證使用者 -->
        @auth
        <div class="text-center bg-green-200 w-full">歡迎：{{$user->acc}}</div>
        <a href="/admin">
        <button class="gray_btn">返回管理</button>
        </a>
        @endauth
        @guest
        <a href="/login">
        <button class="gray_btn">管理登入</button>
        </a>
        @endguest
    </div>
    <div class="text-center w-9/12 mx-auto border-b p-3 mb-3">校園映像區</div>
    <div class="school_image">
        <div id="up" class="up mx-auto"></div>
        <div class="image_contant w-4/6 mx-auto bg-yellow-400">
            @isset($images)
            @foreach($images as $image)
            <img class="img mb-1" src="{{asset('storage/'.$image->img)}}">
            @endforeach
            @endisset
        </div>
        <div id="down" class="down mx-auto"></div>
    </div>
</div>

@endsection

@section("script")
<script>
    $('.option').hover(
        function() {
            $(this).children('.sublist').show()
        },
        function() {
            $(this).children('.sublist').hide()
        }
    )
    let num=$('.img').length
    let p=0;
    $('.img').each((idx,dom)=>{
        if(idx<3){
            $(dom).show()
        }
    })
    $('#up,#down').on('click',function(){
        $('.img').hide()
        switch($(this).attr('id')){
            case 'up':
                p=(p>0)?--p:p;
            break;
            case 'down':
                p=(p<num-3)?++p:p;
            break;
        }
        $('.img').each((idx,dom)=>{
        if(idx>=p && idx<=p+2){
            $(dom).show()
        }
        })
    })
    $('.mv').eq(0).show()
    let mvNum=$('.mv').length
    let now=0
    setInterval(()=>{
        $('.mv').hide()
        ++now
        $('.mv').eq(now%mvNum).show()
    },3000)

    $('.news').hover(
        function(){
            $(this).children('div').show()
        },
        function(){
            $(this).children('div').hide()
        }
    )
</script>
@endsection