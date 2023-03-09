<?php

namespace App\Models;
use Illuminate\Support\Str;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'image', 'type_id', 'technology_id'];
    use HasFactory;

    public static function createSlug($title){
        return Str::slug($title, '-');
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }
}
