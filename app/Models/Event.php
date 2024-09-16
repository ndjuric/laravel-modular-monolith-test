<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['venue_id', 'name', 'available_tickets', 'ticket_sales_end_date'];
}
