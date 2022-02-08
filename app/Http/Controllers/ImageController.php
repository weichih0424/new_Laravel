<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Image::paginate(3);
        //dd($all); //L內建除錯指令 類似var_dump
        $cols = [
            [
                'title'=>'校園映像圖片',
                'grid'=>'9',
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
                    'class'=>'w-2/3 m-auto',
                    'grid'=>'9'
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
        $this->view['header']='校園映像圖片管理';
        $this->view['module']='Image';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;
        $this->view['paginate']=$all->links();
        // $view = [
        //     'header' => '校園映像圖片管理',
        //     'module' => 'Image',
        //     'cols' => $cols,
        //     'rows' => $rows,
        // ];
        // dd($view);
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
            'action' => '/admin/image',
            'modal_header' => "新增校園映像",
            'modal_body' => [
                [
                    'label' => '校園映像圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img',
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
            $title = new Image;
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName()); //取得上傳的原始檔名
            //storeAs（目錄,檔名）
            $title->img = $request->file('img')->getClientOriginalName();
            $title->save();
        }

        return redirect('/admin/image'); //同header
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

        $title = Image::find($id);
        $view = [
            'action' => '/admin/image/' . $id,
            'method' => 'PATCH',
            'modal_header' => "編輯校園映像圖片資料",
            'modal_body' => [
                [
                    'label' => '',
                    'tag' => 'img',
                    'src' => $title->img,
                    'class'=>'w-1/3 m-auto',
                    'grid'=>'9'
                ],
                [
                    'label' => '校園映像圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img'
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
        $title = Image::find($id); //明確只撈一筆資料可用此方式
        //$title=Title::where('id',$id)->get(); //撈一個二維陣列的結果(fetchall)

        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            //hasFile->若有檔案 isValid->驗證檔案
            $request->file('img')->storeAs('public', $request->file('img')->getClientOriginalName()); //取得上傳的原始檔名
            //storeAs（目錄,檔名）
            $title->img = $request->file('img')->getClientOriginalName();
        }

        $title->save();
        return redirect('/admin/image');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Image::destroy($id);
        //關於軟刪除可參考官方文件Eloquent ORM->getting started->Soft Deleting
    }

    /**
     * 改變資料顯示狀態
     */
    public function display($id)
    {
        $image = Image::find($id);
        $image->sh=($image->sh=1)%2;
        $image->save();
    }
}
