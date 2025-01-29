<?php

namespace App\Models;

use App\Observers\SupervisorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(SupervisorObserver::class)]
class Supervisor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'email', 'telefono', 'zona', 'sector', 'order'];

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

}
