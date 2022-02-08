<div class="absolute inset-0 flex justify-center items-center" id="baseModal">
  <div class="shell w-4/6 h-2/3 bg-opacity-90 bg-white grid grid-rows-6">
    <form action="{{ $action }}" method="post" enctype="multipart/form-data">
      <div class="modal-header relative row-span-1 border-b">
        <h5 class="text-lg text-center pt-3">{{ $modal_header }}</h5>
        <button type="button" class="closeModal absolute right-2 top-2 text-gray-400 hover:text-gray-600">X</button>
      </div>
      <div class="modal-body row-span-4 text-center">
        @csrf
        @isset($method)
          @method($method)
        @endisset
        <table class="m-auto w-5/6">
          @isset($modal_body)
          @foreach($modal_body as $row)
          <tr>
            <td colspan="2" class="text-center m-auto">
              @if(isset($row['type']) && $row['type']=='file')
              @include("layouts.previewimg")
              @endif
            </td>
          </tr>
          <tr>
            <td class='text-right'>{{$row['label']}}</td>
            <td>
              @switch($row['tag'])
              @case('input')
              @include("layouts.input",$row)
              @break
              @case('textarea')
              @include("layouts.textarea",$row)
              @break
              @case('img')
              @include('layouts.img',$row)
              @break
              @case('embed')
              @include("layouts.embed",$row)
              @break
              @default
              {{ $row['text'] }}
              @endswitch
            </td>
          </tr>
          @endforeach
          @endisset
        </table>
      </div>
      <div class="modal-footer row-span-1 flex justify-center items-center">
        <button type="reset" class="bg-gray-100 hover:bg-gray-200 w-14 h-7 rounded-md m-1">重置</button>
        <button type="submit" class="bg-green-100 hover:bg-green-200 w-14 h-7 rounded-md m-1">儲存</button>
      </div>
    </form>
  </div>
</div>
<script>
  $('.closeModal').on('click', function() {
    $("#baseModal").hide()
    $('#modal').html("")
  })
  $("input[type='file']").on('change', function() {
    const file = this.files[0]; //取得上傳的檔案
    const objectURL = URL.createObjectURL(file); //取得圖檔路徑
    $('#previewimg').attr('src', objectURL);
    $('#previewimg').addClass('w-1/3 m-auto');
    // $('#previewimg').attr('style', 'width:300px; height:30px;');
  });
</script>