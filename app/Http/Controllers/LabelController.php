<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::all();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('labels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|unique:labels'
        ]);

        $label = new Label();
        $label->name = $request->name;
        $label->description = $request->description;

        if ($label->save()) {
            flash(__('flash.success.f.create', ['entity' => 'метка']), 'success');
            return redirect('/labels');
        } else {
            flash(__('Something went wrong while creating label'));
            return redirect('/labels');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('labels');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $label = Label::findOrFail($id);
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $label = Label::findOrFail($id);

        $label->fill([
            'name' => request('name'),
            'description' => request('description')
        ]);

        $label->update();
        flash(__('flash.success.f.change', ['entity' => 'метка']), 'success');
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $label = Label::findOrFail($id);
        $label->Delete();
        flash(__('flash.success.f.delete', ['entity' => 'метка']), 'danger');
        return redirect()->route('labels.index');
    }
}
