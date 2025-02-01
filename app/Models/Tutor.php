<?php

namespace App\Models;

use App\Observers\TutorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

#[ObservedBy(TutorObserver::class)]
class Tutor extends Model
{
    use HasFactory;
    protected $fillable = [
        'curp',
        'nombre',
        'apellidoP',
        'apellidoM',
        'calle',
        'exterior',
        'interior',
        'localidad',
        'colonia',
        'cp',
        'municipio',
        'estado',
        'telefono',
        'celular',
        'email',
        'parentesco',
        'ocupacion',
        'order'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }


}
