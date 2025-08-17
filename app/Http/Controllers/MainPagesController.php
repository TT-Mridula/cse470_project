<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Main;
use Illuminate\Support\Facades\Storage;

class MainPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $main = Main::first();
       return view('pages.main', compact('main'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {   
        $this->validate($request,[
            'title' => 'required|string',
             'sub_title' => 'required|string',
        ]);
        $main = Main::first();
        $main->title = $request->title;
        $main->sub_title = $request->sub_title;

        if ($request->hasFile('bc_img')) {
        // delete old image if exists
        if ($main->bc_img && Storage::exists(str_replace('/storage', 'public', $main->bc_img))) {
            Storage::delete(str_replace('/storage', 'public', $main->bc_img));
        }

        // store new one
        $path = $request->file('bc_img')->store('img', 'public'); // returns "img/xxxx.jpg"
        $main->bc_img = 'storage/'.$path;                         // "storage/img/xxxx.jpg"
        $main->save();
        }

    $main->save();

    return redirect()->back()->with('success', 'Main Page data has been updated successfully!');
    }


    
    
}