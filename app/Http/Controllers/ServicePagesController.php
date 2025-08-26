<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
class ServicePagesController extends Controller
{
    public function list()
    {
        $services = Service::all(); // Fetch all services from the database
        return view('pages.services.list', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'icon' => 'required|string',
            'title' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);
        $services = new Service;
        $services->icon = $request->icon;
        $services->title = $request->title;
        $services->category = $request->category;
        $services->description = $request->description;
        $services->save();

        return redirect()->route('admin.services.list')->with('success', 'New Service Created Successfully');


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
        $service = Service::find($id);
        return view('pages.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request,[
            'icon' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        $services = Service::find($id);
        $services->icon = $request->icon;
        $services->title = $request->title;
        $services->description = $request->description;
        $services->save();

        return redirect()->route('admin.services.list')->with('success', ' Service Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        $service->delete();

        return redirect()->route('admin.services.list')->with('success','Service Deleted Successfully');

    }
}
