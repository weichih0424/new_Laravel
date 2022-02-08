<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Ad;
use App\Models\Mvim;
use App\Models\News;
use Auth;

class HomeController extends MyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->sidebar();

        $mvims=Mvim::where('sh',1)->get();
        $news=News::where('sh',1)->get()->filter(function($value,$key){
            if($key>4){ //key由0開始 過濾5以上增加more值
                $this->view['more']='/news';
                return null; //超過指定筆數就停止執行  節省效能
            }else{
                return $value;
            }
        });
        //dd($news,$this->view);
        $this->view['mvims']=$mvims;
        $this->view['news']=$news;

        return view('frontend.center',$this->view);
    }

    protected function sidebar(){
        $menus=Menu::where('sh',1)->get();
        $images=Image::where('sh',1)->get();
        foreach($menus as $key=>$menu){
            $subs=$menu->subs;
            $menu->subs=$subs;//增加(subs)屬性 將次選單放入主選單
            // dd($menu);
            $menus[$key]=$menu; //將迴圈增加的參數重新合併進$menus
        }
        $ads=implode(' ',Ad::where('sh',1)->get()->pluck('text')->all()); 
        //laravel內建collections方法  pluck() -> 摘取回傳資料內的特定參數  all() -> 回傳陣列(也可使用toArray())
        // dd($ads);
        //dd($menus);
        // dd(Auth::user());
        if(Auth::user()){
            $this->view['user']=Auth::user(); //取的使用者資訊
        }
        $this->view['menus']=$menus;//將menus併入變數view
        $this->view['images']=$images;
        $this->view['ads']=$ads;
        // dd($images);
    }
}