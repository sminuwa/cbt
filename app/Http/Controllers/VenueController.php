<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function store(Request $request)
    {
        Venue::updateOrCreate(
            ['id' => $request->venueId],
            ['centre_id' => $request->venueCentreId, 'name' => $request->venueName, 'location' => $request->venueLocation, 'capacity' => $request->venueCapacity]
        );

        return response()->json(['success' => 'Venue saved successfully.']);
    }

    public function edit($id)
    {
        $venue = Venue::find($id);
        return response()->json($venue);
    }

    public function destroy($id)
    {
        Venue::find($id)->delete();
        return response()->json(['success' => 'Venue deleted successfully.']);
    }
}
