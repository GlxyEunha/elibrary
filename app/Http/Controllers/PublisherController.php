<?php

namespace App\Http\Controllers;

use App\Models\publisher;
use App\Http\Requests\StorepublisherRequest;
use App\Http\Requests\UpdatepublisherRequest;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('librarian.publisher.index', [
            'publishers' => publisher::Paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('librarian.publisher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepublisherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepublisherRequest $request)
    {
        publisher::create($request->validated());
        return redirect()->route('librarian.publishers')->with('success', 'Publisher added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(publisher $publisher)
    {
        return view('librarian.publisher.edit', [
            'publisher' => $publisher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepublisherRequest  $request
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepublisherRequest $request, $id)
    {
        $publisher = publisher::find($id);
        $publisher->name = $request->name;
        $publisher->save();

        return redirect()->route('librarian.publishers')->with('success', 'Publisher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        publisher::find($id)->delete();
        return redirect()->route('librarian.publishers')->with('success', 'Publisher deleted successfully.');
    }
}
