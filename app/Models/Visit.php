<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["visitor_id","laboratory_id","user_id"];

    public function visitor(){
        return $this->belongsTo(Visitor::class);
    }
    public function laboratory(){
        return $this->belongsTo(Laboratory::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
