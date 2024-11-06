<?php

namespace Modules\Venue\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Venue\Database\Factories\VenueFactory;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capacity'];

    public function events()
    {
        return $this->hasMany('Modules\Event\Entities\Event');
    }

    protected static function newFactory()
    {
        return VenueFactory::new();
    }
}