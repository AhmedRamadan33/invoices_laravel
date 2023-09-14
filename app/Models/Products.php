<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table ='products';
    protected $fillable = [
      'name',
      'description',
      'section_id',
    ];

    public function sections(){
        return $this->belongsTo(Sections::class,'section_id','id');
    }
}
