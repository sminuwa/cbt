<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Exception;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function store(Request $request)
    {
        try {
            if (isset($request->id))
                $venue = Venue::find($request->id);
            else
            $venue = new Venue();
            $venue->centre_id = $request->center;
            $venue->name = $request->name;
            $venue->location = $request->venue_location;
            $venue->capacity = $request->capacity;
            if ($venue->save())
                return back()->with(['success' => 'Venue saved successfully.']);

            return back()->with(['error' => 'Oops! Looks like something went wrong.']);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $venue = Venue::find($id);
        return response()->json($venue);
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();
        return response()->json(['success' => 'Venue deleted successfully.']);
    }
}
