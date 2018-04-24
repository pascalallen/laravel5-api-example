<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use Illuminate\Support\Facades\Redirect;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::all();
    }

    public function show(Reservation $reservation)
    {
        return $reservation;
    }

    public function store(Request $request)
    {
        $reservation = Reservation::create($request->all());

        // return response()->json($reservation, 201);
        return Redirect::back()->with('message','Operation Successful !');
    }

    public function update(Request $request, Reservation $reservation)
    {
        $reservation->update($request->all());

        return response()->json($reservation, 200);
    }

    public function delete(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(null, 204);
    }

    public function findByDate(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $reservations = Reservation::whereRaw("? NOT BETWEEN start_date AND end_date", [$from, $to])->get();
        return $reservations;
    }
}
