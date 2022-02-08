<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Title;
use Tests\TestCase;

class TitleTest extends TestCase
{
    // use RefreshDatabase;
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_posts_count()
    {
        $num=5;//生成五筆假資料
        $all = Title::count()+$num;
        Title::factory()->count($num)->create(); 
        $posts = Title::get();
        $this->assertCount($all,$posts); //確認資料筆數
    }
    public function test_index_get()
    {
        $response = $this->withoutMiddleware()->get('/admin/title');
        $response->assertStatus(200); //確認狀態碼
    }

    //測試 /posts/store 路徑能否正常用來新增資料
    public function test_store_post()
    {
        $post = Title::factory()->make(); //make工廠類可自行填入欲生成資料
        $response=$this->withoutMiddleware()->post('/admin/title',['text'=>$post['text'],'img'=>$post['img'],'sh'=>$post['sh']]);
        $response->assertStatus(201);
        //$response->assertRedirect('/admin/title');
    }
}
