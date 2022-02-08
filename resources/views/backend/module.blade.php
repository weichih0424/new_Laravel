@extends("layouts/layout")

@section("main")
@include('layouts.backend_sidebar')
<div class="main_contant col-span-9 border">
    <div class="grid grid-cols-12">
        <div class="col-span-8 text-center p-3 relative">
            @if($module != 'Total' && $module != 'Bottom')
            <button class=" absolute align-middle left-2 bg-blue-100 hover:bg-blue-200 w-14 h-7 rounded-md" id="addRow">新增</button>
            @endif
            <p>後台管理區</p>
        </div>
        <div class="col-span-4 w-full">
        <a href="/logout">
        <button class=" w-full bg-gray-100 hover:bg-gray-200 p-3 rounded-md">管理登出</button>
        </a>
        </div>
    </div>
    <div class="contant border w-full h-full">
        <div class="text-sm text-center border-b bg-yellow-400 p-3">{{$header}}</div>
        <div class="grid grid-cols-12 text-center text-sm">
            @isset($cols)
            @if($module != 'Total' && $module != 'Bottom')
            @foreach($cols as $col)
            <div class="col-span-{{$col['grid']}} bg-yellow-300 py-1">{{$col['title']}}</div>
            @endforeach
            @endif
            @endisset
        </div>
        <div class="w-full h-5/6 overflow-auto">
            @isset($rows)
            @if($module != 'Total' && $module != 'Bottom')
            @foreach($rows as $row)
            <div class="item grid grid-cols-12 text-center">
                @foreach($row as $item)
                @switch($item['tag'])
                @case('img')
                @include('layouts.img',$item)
                @break
                @case('button')
                @include('layouts.button',$item)
                @break
                @case('textarea')
                @include('layouts.textarea',$item)
                @break
                @default
                @include('layouts.text',$item)
                @endswitch
                @endforeach
            </div>
            @endforeach
            @else
            <div class="grid grid-cols-12">
                <div class="col-span-{{ $cols['grid'] }} bg-yellow-200 flex justify-center items-center">{{ $cols['title'] }}</div>
                <div class="col-span-{{ $rows[0]['grid'] }} bg-gray-100 flex justify-center items-center">{{ $rows[0]['text'] }}</div>
                <div class="col-span-2">
                    @include('layouts.button',$rows[1])
                </div>
            </div>
            @endif
            @endisset
        </div>
        @switch($module)
            @case('Image')
            @case('News')
                {!!$paginate!!} 
                <!-- 因安全性問題 前台會將變數內容以字串表示 需加 ！ 執行才能正常顯示 -->
            @break
        @endswitch
    </div>
</div>
@endsection

@section("script")
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#addRow').on('click', function() {
        @if(isset($menu_id))
        $.get("/modals/add{{ $module }}/{{$menu_id}}", function(modal) {
            $("#modal").html(modal)
            $("#baseModal").show()
            //尚缺清除暫存
        })
        @else
        $.get("/modals/add{{ $module }}", function(modal) {
            $("#modal").html(modal)
            $("#baseModal").show()
            //尚缺清除暫存
        })
        @endif
    })
    $('.edit').on('click', function() {
        let id = $(this).data('id')
        $.get(`/modals/{{ strtolower($module) }}/${id}`, function(modal) {
            $("#modal").html(modal)
            $("#baseModal").show()
        })
    })
    $('.delete').on('click', function() {
        let id = $(this).data('id')
        let _this=$(this)
        let admin = $(this).data('admin')
        Swal.fire({
            title: '確定要刪除嗎？',
            icon: 'question',
            iconColor: '#ff3333',
            showDenyButton: true,
            confirmButtonText: `刪除！`,
            confirmButtonColor: 'red',
            denyButtonText: `取消`,
            denyButtonColor: 'gray'
        }).then((result) => {
            if (result.isConfirmed) {
                if (admin != 'admin') {
                    $.ajax({
                        type: 'delete',
                        url: `/admin/{{ strtolower($module) }}/${id}`,
                        success: function() {
                            Swal.fire('已成功刪除', '', 'success')
                            _this.parents('.item').remove()
                            // location.reload()
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Oops...',
                        text: '最高權限帳號無法刪除',
                    })
                }
            }
        })
    })
    $('.show').on('click', function() {
        let id = $(this).data('id')
        let _this=$(this)
        $.ajax({
            type: 'patch',
            url: `/admin/{{ strtolower($module) }}/sh/${id}`,
            @if($module=='Title')
            success: function(img) {
                if(_this.text()=='顯示'){
                    $('.show').each((idx,dom)=>{ //each迴圈找第一筆資料
                        if($(dom).text()=='隱藏'){
                            $(dom).text('顯示')
                            $(dom).addClass('bg-green-100')
                            return false //中斷迴圈 此處無法使用break
                        }
                    })
                    _this.text('隱藏')
                    _this.removeClass('bg-green-100')
                }else{
                    $('.show').text('隱藏')
                    $('.show').removeClass('bg-green-100')
                    _this.text('顯示')
                    _this.addClass('bg-green-100')
                }
                $('.header a img').attr('src',"http://laravel-q1.com/storage/"+img)
            }
            @else
            success: function() {
                if(_this.text()=='顯示'){
                    _this.text('隱藏')
                    _this.removeClass('bg-green-100')
                }else{
                    _this.text('顯示')
                    _this.addClass('bg-green-100')
                }
            }
            @endif
        })
    })

    $('.sub').on('click',function(){
        let id=$(this).data('id')
        location.href=`/admin/submenu/${id}`
    })
</script>
@endsection