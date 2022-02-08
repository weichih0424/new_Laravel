<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //載入軟刪除功能
class Title extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable=['text','img','sh'];
}