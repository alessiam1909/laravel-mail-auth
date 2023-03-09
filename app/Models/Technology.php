<?php

namespace App\Models;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public static function createSlug($title){
        return Str::slug($title, '-');
    }

    public function projects(){
        return $this->belongsToMany(Project::class);
    }
}
