<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VenueController extends Controller
{
    public function index()
    {
        Log::info('Log test: Laravel log file created.');
        $venues = Venue::all();
        return view('venues.index', compact('venues'));
    }

    public function create()
    {
        return view('venues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:venues,name',
            'ownership' => 'required|in:club,third_party,private',
            'address' => 'required|string|max:500',
        ]);

        Venue::create($request->all());

        return redirect()->route('venues.index')->with('success', 'Venue berhasil ditambahkan.');
    }

    public function edit(Venue $venue)
    {
        return view('venues.edit', compact('venue'));
    }

    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:venues,name,' . $venue->id,
            'ownership' => 'required|in:club,third_party,private',
            'address' => 'required|string|max:500',
        ]);

        $venue->update($request->all());

        return redirect()->route('venues.index')->with('success', 'Venue berhasil diperbarui.');
    }
}
