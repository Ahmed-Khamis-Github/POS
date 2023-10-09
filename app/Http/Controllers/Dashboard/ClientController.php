<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
        $clients = Client::when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
        })->paginate(10);
        return view('dashboard.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'phone.0' => 'required|max:15',
            'phone.1' => 'max:15',
            'address' => 'required|string'
        ];

        $request->validate($rules);
        $clientData = $request->all();
        $clientData['phone'] = [$request->input('phone.0'), $request->input('phone.1')]; // cast phone to an array


        Client::create($clientData);
        return redirect()->route('dashboard.clients.index')->with('success', 'client created Successfully');
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
        $client = Client::findOrFail($id);
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);
        $rules = [
            'name' => 'required|string',
            'phone.0' => 'required|max:15',
            'phone.1' => 'max:15',
            'address' => 'required|string'
        ];

        $request->validate($rules);
        $clientData = $request->all();
        $clientData['phone'] = [$request->input('phone.0'), $request->input('phone.1')]; // cast phone to an array

        $client->update($clientData);

        return redirect()->route('dashboard.clients.index')->with('success', 'client updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('dashboard.clients.index')->with('success', 'client deleted Successfully');
    }
}
