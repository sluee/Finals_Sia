<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable= ['name', 'email', 'phone', 'pic'];

    protected $appends = ['picUrl'];

    public function getPicUrlAttribute() {
        $url = $this->pic ? asset("images/supplier_pics/" . $this->pic) : "https://icons.iconarchive.com/icons/diversity-avatars/avatars/256/charlie-chaplin-icon.png";
        return $url;
    }

    public function products(){
        return $this->hasMany(Product::class , 'sup_id');
    }
}
