<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Total;

class TotalController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Total::first();
        //dd($all); //L內建除錯指令 類似var_dump
        $cols = [
                'title' => '進站總人數',
                'grid' => '5',
        ];
        $rows = [
            [
                'text' => $all->total,
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
        $this->view['header']='進站總人數管理';
        $this->view['module']='Total';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;
        // $view = [
        //     'header' => '進站總人數管理',
        //     'module' => 'Total',
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
        $total = Total::find($id);
        $view = [
            'action' => '/admin/total/' . $id,
            'method' => 'PATCH',
            'modal_header' => "編輯進站總人數資料",
            'modal_body' => [
                [
                    'label' => '進站總人數',
                    'tag' => 'input',
                    'type' => 'number',
                    'name' => 'total',
                    'value' => $total->total
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
        $total = Total::find($id);

        if ($total->total != $request->input('total')) {
            $total->total = $request->input('total');
        }

        $total->save();
        return redirect('/admin/total');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('destroy');
    }
}
