<?php

namespace App\Http\Controllers;

use App\Models\Termination;
use Illuminate\Http\Request;
use App\Models\Subu;

class TerminationController extends Controller
{
    // Show the form to select employee and add reason
    public function create()
    {
        $employees = Subu::all(); // Get all employees for the dropdown
        return view('terminations.create', compact('employees'));
    }

    // Store the termination reason in the database
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'reason' => 'required|string',
        ]);

        Termination::create([
            'employee_id' => $request->employee_id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('terminations.index');
    }

    // List all terminations
    public function index()
    {
        $terminations = Termination::with('employee')->get();
        return view('terminations.index', compact('terminations'));
    }

    // Show termination details in a popup
    public function show($id)
    {
        $termination = Termination::with('employee')->findOrFail($id);
        return response()->json($termination);
    }

    // Generate the termination letter for the employee
    public function terminationLetter($id)
    {
        $termination = Termination::with('employee')->findOrFail($id);
        return view('terminations.letter', compact('termination'));
    }
}

