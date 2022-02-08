<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_menu extends Model
{
    use HasFactory;
    protected $fillable=['text','href','menu_id'];
    
    public function menu(){
        return $this->belongsTo('App\Models\Menu');//關聯資料表 多對一
        //return $this->belongsTo('App\Models\Menu','外鍵');//關聯資料表 多對一
    }
}
