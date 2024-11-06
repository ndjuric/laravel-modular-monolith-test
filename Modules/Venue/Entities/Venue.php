<?php

namespace Modules\Venue\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Event\Entities\Event;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capacity'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}