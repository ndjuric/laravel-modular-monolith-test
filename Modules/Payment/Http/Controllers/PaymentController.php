<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Event\Entities\Event;
use Modules\Payment\Entities\Purchase;
use Illuminate\Support\Str;

class PaymentController extends Controller
{  
    public function purchase(Request $request, $event_id)
    {
        $request->validate(['email' => 'required|email']);
    
        return DB::transaction(function () use ($request, $event_id) {
            $event = Event::with('venue')
                ->where('id', $event_id)
                ->lockForUpdate()
                ->firstOrFail();
    
            if (now()->greaterThan($event->ticket_sales_end_date)) {
                return response()->json(['error' => 'The event is closed.'], 400);
            }
    
            $soldTickets = Purchase::where('event_id', $event_id)->count();
            $availableTickets = $event->venue->capacity - $soldTickets;
    
            if ($availableTickets <= 0) {
                return response()->json(['error' => 'No available seats for this event.'], 400);
            }
    
            $exists = Purchase::where('event_id', $event_id)
                ->where('email', $request->email)
                ->exists();
    
            if ($exists) {
                return response()->json(['error' => 'Email already used for this event.'], 400);
            }
    
            $transactionId = (string) Str::uuid();
    
            Purchase::create([
                'event_id'       => $event_id,
                'email'          => $request->email,
                'transaction_id' => $transactionId,
            ]);
    
            return response()->json(['transaction_id' => $transactionId]);
        });
    }
}