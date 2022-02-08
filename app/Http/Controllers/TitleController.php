<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //封包外部傳來的資料
use App\Models\Title; //載入欲使用的model
use Symfony\Component\HttpFoundation\Response;
class TitleController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($this->view);
        $all = Title::all();
        //dd($all); //L內建除錯指令 類似var_dump
        $cols = [
            [
                'title'=>'網站標題',
                'grid'=>'5',
            ],
            [
                'title'=>'替代文字',
                'grid'=>'4',
            ],
            [
                'title'=>'功能',
                'grid'=>'3',
            ]
        ];
        $rows = [];
        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => 'img',
                    'src' => $a->img,
                    'class'=>'w-full',
                    'grid'=>'5'
                ],
                [
                    'tag' => '',
                    'text' => $a->text,
                    'grid'=>'4'
                ],
                [
                    'tag' => 'button',
                    'action' => 'show',
                    'color' => ($a->sh == 1) ? 'bg-green-100' : 'bg-gray-100',
                    'hover' => 'bg-green-200',
                    'type' => 'button',
                    'id' => $a->id,
                    'text' => ($a->sh == 1) ? '顯示' : '隱藏',
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'action' => 'delete',
                    'id' => $a->id,
                    'color' => 'bg-gray-100',
                    'hover' => 'bg-red-200',
                    'text' => '刪除'
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'action' => 'edit',
                    'id' => $a->id,
                    'color' => 'bg-gray-100',
                    'hover' => 'bg-indigo-300',
                    'text' => '編輯'
                ]
            ];
            $rows[] = $tmp;
        }
        // dd($cols);
        //$useTitle=Title::where('sh',1)->first();//唯一一筆
        $this->view['header']='網站標題管理';
        $this->view['module']='Title';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;
        // $view = [
        //     'header' => '網站標題管理',
        //     'module' => 'Title',
        //     'cols' => $cols,
        //     'rows' => $rows,
        //     //'useTitle'=>$useTitle,
        //     'useTitle'=>$this->useTitle,
        // ];
        // dd($this->view);
        return view('backend.module', $this->view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view = [
            'action' => '/admin/title',
            'modal_header' => "新增網站標題",
            'modal_body' => [
                [
                    'label' => '標題區圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img',
                ],
                [
                    'label' => '標題區替代文字',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'text'
                ],
            ],
        ];


        return view("modals.base_modal", $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            //hasFile->若有檔案 isValid->驗證檔案
            $title = new Title;
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName()); //取得上傳的原始檔名
            //storeAs（目錄,檔名）
            $title->img = $request->file('img')->getClientOriginalName();
            $title->text = $request->input('text');
            $title->save();
        }
        return response()->noContent(Response::HTTP_CREATED); //回應狀態碼
        return redirect('/admin/title'); //同header
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $title = Title::find($id);
        $view = [
            'action' => '/admin/title/' . $id,
            'method' => 'PATCH',
            'modal_header' => "編輯網站標題資料",
            'modal_body' => [
                [
                    'label' => '',
                    'tag' => 'img',
                    'src' => $title->img,
                    'class'=>'w-full',
                    'grid'=>''
                ],
                [
                    'label' => '標題區圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img'
                ],
                [
                    'label' => '標題區替代文字',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'text',
                    'value' => $title->text
                ],
            ],
        ];
        return view('modals.base_modal', $view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $title = Title::find($id); //明確只撈一筆資料可用此方式
        //$title=Title::where('id',$id)->get(); //撈一個二維陣列的結果(fetchall)

        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            //hasFile->若有檔案 isValid->驗證檔案
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName()); //取得上傳的原始檔名
            //storeAs（目錄,檔名）
            $title->img = $request->file('img')->getClientOriginalName();
        }

        if ($title->text != $request->input('text')) {
            $title->text = $request->input('text');
        }

        $title->save();
        return redirect('/admin/title');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Title::destroy($id);
        //關於軟刪除可參考官方文件Eloquent ORM->getting started->Soft Deleting
    }

    /**
     * 改變資料顯示狀態
     */
    public function display($id)
    {
        $title = Title::find($id);
        if ($title->sh == 1) {
            $title->sh = 0;
            $findDefault = Title::where('sh', 0)->first(); //找出其他不顯示的第一筆資料
            $findDefault->sh = 1;
            $findDefault->save();
            $img=$findDefault->img;
        } else {
            $title->sh = 1;
            $findshow = Title::where('sh', 1)->first();
            $findshow->sh = 0;
            $findshow->save();
            $img=$title->img;
        }
        $title->save();
        return $img;
    }
}
