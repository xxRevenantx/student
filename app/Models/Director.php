<?php

namespace App\Models;

use App\Observers\DirectorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(DirectorObserver::class)]
class Director extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'email', 'telefono', 'order'];


    
}
