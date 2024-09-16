<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPurchase extends Model
{
    protected $fillable = ['event_id', 'email', 'transaction_id'];
}

