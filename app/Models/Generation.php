<?php

namespace App\Models;

use App\Observers\GenerationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(GenerationObserver::class)]
class Generation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_inicio',
        'fecha_termino',
        'status',
        'level_id',
        'order'
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
