<?php

namespace App\Models;

use App\Observers\GradeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(GradeObserver::class)]
class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['grado', 'grado_numero', 'level_id', 'generation_id', 'grupos', 'order'];


    /**
     * La propiedad $cast se utiliza para especificar cómo deben ser convertidos los atributos cuando se acceden.
     * En este caso, el atributo 'grupos' será convertido a un array.
     */
    protected $casts = [
        'grupos' => 'array'
    ];


    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }


    public function students()
    {
        return $this->hasMany(Student::class);
    }



}
