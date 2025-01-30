<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['grado', 'grade_numero', 'level_id', 'generation_id'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }
}
