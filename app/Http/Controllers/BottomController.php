<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bottom;

class BottomController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Bottom::first();
        //dd($all); //L內建除錯指令 類似var_dump
        $cols = [
                'title' => '頁尾版權資料',
                'grid' => '5',
        ];
        $rows = [
            [
                'text' => $all->bottom,
                'grid' => '5'
            ],
            [
                'tag' => 'button',
                'type' => 'button',
                'action' => 'edit',
                'id' => $all->id,
                'color' => 'bg-gray-100',
                'hover' => 'bg-indigo-300',
                'text' => '編輯'
            ]
        ];
        // dd($rows);
        $this->view['header']='頁尾版權管理';
        $this->view['module']='Bottom';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;
        // $view = [
        //     'header' => '頁尾版權管理',
        //     'module' => 'Bottom',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $bottom = Bottom::find($id);
        $view = [
            'action' => '/admin/bottom/' . $id,
            'method' => 'PATCH',
            'modal_header' => "編輯頁尾版權文字",
            'modal_body' => [
                [
                    'label' => '頁尾版權文字',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'bottom',
                    'value' => $bottom->bottom
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
        $bottom = Bottom::find($id);

        if ($bottom->bottom != $request->input('bottom')) {
            $bottom->bottom = $request->input('bottom');
        }

        $bottom->save();
        return redirect('/admin/bottom');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
