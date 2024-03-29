<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Project extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = ['title', 'slug', 'content', 'is_published', 'type_id'];

    public function getFormattedDate($column, $format = 'd/m/Y H:i:s'){
    return Carbon::create($this->$column)->format($format);    
    }

    public function printImage(){
        return asset('storage/' . $this->image);
    }

    public function getAbstract()
    {
        return substr($this->content, 0, 350);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }
}
