<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sub_menu;

class SubMenuController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($menu_id)
    {
        $all = Sub_menu::where("menu_id",$menu_id)->get();  //get()等同 fetchAll
        //dd($all); //L內建除錯指令 類似var_dump
        $cols = [
            [
                'title' => '次選單名稱',
                'grid' => '5',
            ],
            [
                'title' => '次選單連結',
                'grid' => '5',
            ],
            [
                'title' => '功能',
                'grid' => '2',
            ]
        ];
        $rows = [];
        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => '',
                    'text' => $a->text,
                    'grid' => '5'
                ],
                [
                    'tag' => '',
                    'text' => $a->href,
                    'grid' => '5'
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
                ],
            ];
            $rows[] = $tmp;
        }
        // dd($cols);
        $this->view['header']='次選單管理';
        $this->view['module']='SubMenu';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;
        $this->view['menu_id']=$menu_id;
        // $view = [
        //     'header' => '次選單管理',
        //     'module' => 'SubMenu',
        //     'cols' => $cols,
        //     'rows' => $rows,
        //     'menu_id'=>$menu_id
        // ];
        // dd($view);
        return view('backend.module', $this->view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($menu_id)
    {
        $view = [
            'action' => '/admin/submenu/'.$menu_id,
            'modal_header' => "新增次選單",
            'modal_body' => [
                [
                    'label' => '次主選單內容',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'text',
                ],
                [
                    'label' => '次選單連結',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'href'
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
    public function store(Request $request,$menu_id)
    {
        $sub = new Sub_menu;
        $sub->text = $request->input('text');
        $sub->href = $request->input('href');
        $sub->menu_id = $menu_id;
        $sub->save();
        return redirect('/admin/submenu/'.$menu_id);
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
        $sub = sub_menu::find($id);
        $view = [
            'action' => '/admin/submenu/' . $id,
            'method' => 'PATCH',
            'modal_header' => "編輯次選單資料",
            'modal_body' => [
                [
                    'label' => '次選單內容',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'text',
                    'value' => $sub->text
                ],
                [
                    'label' => '次選單連結',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'href',
                    'value' => $sub->href
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
        $sub = Sub_menu::find($id); //明確只撈一筆資料可用此方式
        //$menu=menu::where('id',$id)->get(); //撈一個二維陣列的結果(fetchall)

        if ($sub->text != $request->input('text')) {
            $sub->text = $request->input('text');
        }
        if ($sub->href != $request->input('href')) {
            $sub->href = $request->input('href');
        }

        $sub->save();
        return redirect('/admin/submenu/'.$sub->menu_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sub_menu::destroy($id);
    }
}
