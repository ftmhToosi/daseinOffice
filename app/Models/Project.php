<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function type()
    {
       return $this->belongsToMany(Type::class, 'type_project');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scale()
    {
        return $this->belongsTo(Scale::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
}
