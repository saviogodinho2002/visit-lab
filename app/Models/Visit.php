<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Visit extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public $name = "Visita";
    protected $fillable = ["visitor_id","laboratory_id","user_id"];

    public function visitor(){
        return $this->belongsTo(Visitor::class);
    }
    public function laboratory(){
        return $this->belongsTo(Laboratory::class);
    }
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

}
