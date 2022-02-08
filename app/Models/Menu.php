<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['text','href','sh'];

    public function subs(){
        return $this->hasMany("App\Models\Sub_menu"); //建立關聯資料表 一對多
    }
}