<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Centre;
use App\Models\Venue;
use Illuminate\Http\Request;

class CentreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $centres = Centre::all();
        $venues = Venue::all();
        //$venues = Venue::withCount('computers')->get();
        return view('pages.admin.toolbox.manage_center_venue', compact('centres', 'venues'));
    }

    public function store(Request $request)
    {
        Centre::updateOrCreate(
            ['id' => $request->centreId],
            ['name' => $request->name, 'location' => $request->centreLocation, 'api_key' => $request->api_key, 'secret_key' => $request->secret_key, 'status' => 'Active']
        );

        return back()->with('success', 'Centre saved successfully.');
    }

    public function edit($id)
    {
        $centre = Centre::find($id);
        return response()->json($centre);
    }

    public function destroy($id)
    {
        Centre::find($id)->delete();
        return response()->json(['success' => 'Centre deleted successfully.']);
    }
}
