<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Event\Entities\Event;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'email', 'transaction_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}