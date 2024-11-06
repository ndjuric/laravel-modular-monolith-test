<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Database\Factories\PurchaseFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'email', 'transaction_id'];

    public function event()
    {
        return $this->belongsTo('Modules\Event\Entities\Event');
    }

    protected static function newFactory()
    {
        return PurchaseFactory::new();
    }
}