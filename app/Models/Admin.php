<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['acc','pw'];

    public function getAuthPassword() //透過複寫此方法改變預設的pw名稱
    {
        return $this->pw;
    }
}
