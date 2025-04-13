<?php

namespace App\Http\Controllers;

use App\Models\FutureVisitor;
use Illuminate\Http\Request;

class FutureVisitorController extends Controller
{

    public function index()
    {
        return view('page.future-visitor.index');
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
    public function show(FutureVisitor $futureVisitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FutureVisitor $futureVisitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FutureVisitor $futureVisitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FutureVisitor $futureVisitor)
    {
        //
    }
}
