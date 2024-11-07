<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Event\Database\Factories\EventFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'venue_id', 'ticket_sales_end_date'];

    protected $casts = [
        'ticket_sales_end_date' => 'datetime',
    ];

    public function venue()
    {
        return $this->belongsTo('Modules\Venue\Entities\Venue');
    }

    public function purchases()
    {
        return $this->hasMany('Modules\Payment\Entities\Purchase');
    }

    public function getAvailableTicketsAttribute()
    {
        $soldTickets = $this->purchases()->count();
        return $this->venue->capacity - $soldTickets;
    }

    protected static function newFactory()
    {
        
        return EventFactory::new();
    }
}