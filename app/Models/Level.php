<?php

namespace App\Models;

use App\Observers\LevelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(LevelObserver::class)]
class Level extends Model
{
    use HasFactory;

    protected $fillable = ['level',  'slug', 'imagen', 'color', 'cct', 'director_id', 'supervisor_id', 'order'];

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

}
