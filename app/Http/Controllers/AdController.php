<?php

namespace App\Http\Controllers;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Ad::all();
        //dd($all); //L內建除錯指令 類似var_dump
        $cols = [
            [
                'title'=>'動態文字廣告',
                'grid'=>'10',
            ],
            [
                'title'=>'功能',
                'grid'=>'2',
            ]
        ];
        $rows = [];
        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => '',
                    'text' => $a->text,
                    'grid'=>'10'
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
            ];
            $rows[] = $tmp;
        }
        // dd($cols);
        $this->view['header']='動態文字廣告管理';
        $this->view['module']='Ad';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;
        // $view = [
        //     'header' => '動態文字廣告管理',
        //     'module' => 'Ad',
        //     'cols' => $cols,
        //     'rows' => $rows,
        // ];
        // dd($view);
        // return view('backend.module', $view);
        return view('backend.module', $this->view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view=[
            'action'=>'/admin/ad',
            'modal_header'=>"新增動態廣告文字",
            'modal_body'=>[
                [
                    'label'=>'動態廣告文字',
                    'tag'=>'input',
                    'type'=>'text',
                    'name'=>'text',
                ],
            ],
        ];
        return view("modals.base_modal",$view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $ad = new Ad;
            $ad->text = $request->input('text');
            $ad->save();

        return redirect('/admin/ad'); //同header
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
        $ad = Ad::find($id);
        $view = [
            'action' => '/admin/ad/' . $id,
            'method' => 'PATCH',
            'modal_header' => "編輯動態廣告文字",
            'modal_body' => [
                [
                    'label' => '動態廣告文字',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'text',
                    'value' => $ad->text
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
        $ad = Ad::find($id); //明確只撈一筆資料可用此方式
        //$ad=Title::where('id',$id)->get(); //撈一個二維陣列的結果(fetchall)

        if ($ad->text != $request->input('text')) {
            $ad->text = $request->input('text');
            $ad->save();
        }
        return redirect('/admin/ad');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ad::destroy($id);
    }

    public function display($id)
    {
        $ad = Ad::find($id);
        $ad->sh=($ad->sh+1)%2;
        $ad->save();
    }
}
