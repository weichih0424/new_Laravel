<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\auth; //引入認證機制
use Hash; //加密機制 等同 use Illuminate\Support\Facades\Hash 於config/app.php 內有定義別名
class AdminController extends HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Admin::all();
        //dd($all); //Laravel內建除錯指令 類似var_dump
        $cols = [
            [
                'title'=>'帳號',
                'grid'=>'5',
            ],
            [
                'title'=>'密碼',
                'grid'=>'5',
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
                    'text' => $a->acc,
                    'grid'=>'5'
                ],
                [
                    'tag' => '',
                    'text' => '**********',
                    'grid'=>'5'
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'action' => 'delete',
                    'id' => $a->id,
                    'color' => 'bg-gray-100',
                    'hover' => 'bg-red-200',
                    'text' => '刪除',
                    'admin'=>$a->acc
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
        $this->view['header']='管理者管理';
        $this->view['module']='Admin';
        $this->view['cols']=$cols;
        $this->view['rows']=$rows;
        // $view = [
        //     'header' => '管理者管理',
        //     'module' => 'Admin',
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
            'action' => '/admin/admin',
            'modal_header' => "新增管理者",
            'modal_body' => [
                [
                    'label' => '管理者帳號',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'acc'
                ],
                [
                    'label' => '管理者密碼',
                    'tag' => 'input',
                    'type' => 'password',
                    'name' => 'pw'
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
        $admin = new Admin;
        $admin->acc=$request->input('acc');
        $admin->pw=Hash::make($request->input('pw'));
        $admin->save();
        return redirect('/admin/admin');
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
        $admin = Admin::find($id);
        $view = [
            'action' => '/admin/admin/' . $id,
            'method' => 'PATCH',
            'modal_header' => "編輯管理者資料",
            'modal_body' => [
                [
                    'label' => '管理者帳號',
                    'tag' => '',
                    'text' => $admin->acc
                ],
                [
                    'label' => '管理者密碼',
                    'tag' => 'input',
                    'type' => 'password',
                    'name' => 'pw',
                    'value' => '**********'
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
        $admin = Admin::find($id);
        if ($admin->pw != $request->input('pw')) {
            $admin->pw = Hash::make($request->input('pw'));
        }

        $admin->save();
        return redirect('/admin/admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
    }

    public function showLoginForm()
    {
        parent::sidebar();//執行繼承自HomeController的index方法
        return view('frontend.login',$this->view);
    }

    public function login(Request $request){
        $user=[
            'acc'=>$request->input('acc'),
            'password'=>$request->input('pw') //認證機制pw名稱需為password
        ];
        if(Auth::attempt($user)){
            return redirect('/admin');
        }else{
            return redirect('/login')->with('error','帳號或密碼錯誤');
        }
        // $acc=$request->input('acc');
        // $pw=$request->input('pw');
        // $check=Admin::where('acc',$acc)->where('pw',$pw)->count();
        // if($check){
        //     return redirect('/admin');
        // }else{
        //     return redirect('/login')->with('error','帳號或密碼錯誤'); //with帶入錯誤訊息值
        // }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
