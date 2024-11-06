<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Event\Entities\Event;
use Modules\Payment\Entities\Purchase;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $events = Event::with('venue')->get()->map(function ($event) {
            $soldTickets = Purchase::where('event_id', $event->id)->count();
            $availableTickets = $event->venue->capacity - $soldTickets;

            return [
                'event_name' => $event->name,
                'available_tickets' => $availableTickets,
                'venue_name' => $event->venue->name,
                'ticket_sales_end_date' => $event->ticket_sales_end_date->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('event::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('event::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('event::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
