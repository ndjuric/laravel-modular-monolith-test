<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Venue\Entities\Venue;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'venue_id', 'ticket_sales_end_date'];

    protected $casts = [
        'ticket_sales_end_date' => 'datetime'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}