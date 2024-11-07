<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Event\Entities\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('venue')->get()->map(function ($event) {
            return [
                'event_name'            => $event->name,
                'available_tickets'     => $event->available_tickets,
                'venue_name'            => $event->venue->name,
                'ticket_sales_end_date' => $event->ticket_sales_end_date->toDateTimeString(),
            ];
        });

        return response()->json($events);
    }
}