<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of technicians
     */
    public function index()
    {
        $technicians = Technician::latest()->paginate(15);
        return view('technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new technician
     */
    public function create()
    {
        return view('technicians.create');
    }

    /**
     * Store a newly created technician
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:technicians,email',
        ]);

        Technician::create($validated);

        return redirect()->route('technicians.index')
            ->with('success', 'Technician created successfully.');
    }

    /**
     * Display the specified technician
     */
    public function show(Technician $technician)
    {
        return view('technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing a technician
     */
    public function edit(Technician $technician)
    {
        return view('technicians.edit', compact('technician'));
    }

    /**
     * Update the specified technician
     */
    public function update(Request $request, Technician $technician)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:technicians,email,' . $technician->id,
        ]);

        $technician->update($validated);

        return redirect()->route('technicians.index')
            ->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified technician
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();
        return redirect()->route('technicians.index')
            ->with('success', 'Technician deleted successfully.');
    }
}
