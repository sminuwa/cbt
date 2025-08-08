<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\TestCode;
use Illuminate\Http\Request;
use Exception;

class TestCodeController extends Controller
{
    public function index()
    {
        $testCodes = TestCode::orderBy('name')->get();
        return view('pages.admin.toolbox.manage_test_codes', compact('testCodes'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:test_codes,name,' . $request->id
            ]);

            if ($request->id) {
                // Update existing
                $testCode = TestCode::findOrFail($request->id);
                $testCode->update([
                    'name' => $request->name
                ]);
                $message = 'Test Code updated successfully';
            } else {
                // Create new
                TestCode::create([
                    'name' => $request->name
                ]);
                $message = 'Test Code created successfully';
            }

            return back()->with('success', $message);
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(TestCode $testCode)
    {
        try {
            // Check if test code is being used
            if ($testCode->test_configs()->count() > 0) {
                return back()->with('error', 'Cannot delete test code. It is being used in test configurations.');
            }

            $testCode->delete();
            return back()->with('success', 'Test Code deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

