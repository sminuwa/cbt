<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\TestType;
use Illuminate\Http\Request;
use Exception;

class TestTypeController extends Controller
{
    public function index()
    {
        $testTypes = TestType::orderBy('name')->get();
        return view('pages.admin.toolbox.manage_test_types', compact('testTypes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:test_types,name,' . $request->id
            ]);

            if ($request->id) {
                // Update existing
                $testType = TestType::findOrFail($request->id);
                $testType->update([
                    'name' => $request->name
                ]);
                $message = 'Test Type updated successfully';
            } else {
                // Create new
                TestType::create([
                    'name' => $request->name
                ]);
                $message = 'Test Type created successfully';
            }

            return back()->with('success', $message);
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(TestType $testType)
    {
        try {
            // Check if test type is being used
            if ($testType->test_configs()->count() > 0) {
                return back()->with('error', 'Cannot delete test type. It is being used in test configurations.');
            }

            $testType->delete();
            return back()->with('success', 'Test Type deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

