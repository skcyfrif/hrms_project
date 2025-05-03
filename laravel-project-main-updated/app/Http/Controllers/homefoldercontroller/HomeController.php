<?php

namespace App\Http\Controllers\homefoldercontroller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function OverView()
    {
        //
        // $types = (modelname)::latest()->get();

        // return view('homefolder.overview' , compact('types'));
        return view('homefolder.overview');
    }
    public function AnnounceMents()
    {
        //
        // $types = (modelname)::latest()->get();

        // return view('homefolder.overview' , compact('types'));
        return view('homefolder.announcements');
    }

    public function QuickLinks()
    {
        //
        // $types = (modelname)::latest()->get();

        // return view('homefolder.overview' , compact('types'));
        return view('homefolder.quicklinks');
    }

    public function MyDashboard()
    {
        //
        // $types = (modelname)::latest()->get();

        // return view('homefolder.overview' , compact('types'));
        return view('homefolder.dashboard');
    }
}
