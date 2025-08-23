<?php

namespace App\Http\Controllers\Admin\Centre;

use App\Http\Controllers\Controller;
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
            $request->validate([
                'center' => 'required|exists:centres,id',
                'name' => 'required|string|max:255',
                'venueLocation' => 'required|string|max:255',
                'capacity' => 'required|integer|min:1',
            ]);

            if (isset($request->id)) {
                $venue = Venue::findOrFail($request->id);
            } else {
                $venue = new Venue();
            }
            
            $venue->centre_id = $request->center;
            $venue->name = $request->name;
            $venue->location = $request->venueLocation;
            $venue->capacity = $request->capacity;
            
            if ($venue->save()) {
                return back()->with(['success' => 'Venue saved successfully.']);
            }

            return back()->with(['error' => 'Oops! Looks like something went wrong.']);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $venue = Venue::findOrFail($id);
        return response()->json($venue);
    }

    public function destroy($id)
    {
        try {
            $venue = Venue::findOrFail($id);
            $venue->delete();
            return response()->json(['success' => true, 'message' => 'Venue deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}