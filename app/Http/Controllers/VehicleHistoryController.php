<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleHistory;
use Illuminate\Http\Request;

class VehicleHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request, $vehicleId)
    {
        // Validate the request
        $request->validate([
            'description' => 'required|string|max:255',
            'service_date' => 'required|date',
        ]);

        // Find the vehicle
        $vehicle = Vehicle::findOrFail($vehicleId);

        // Create the vehicle history record
        VehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'description' => $request->description,
            'service_date' => $request->service_date,
        ]);

        // Redirect back to the vehicle edit page with success message
        return redirect()->route('vehicles.show', $vehicle->id)->with('success', 'Vehicle history added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
