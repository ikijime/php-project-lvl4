<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'create', 'edit', 'update', 'destroy']);
    }

    public function index(): View
    {
        $labels = Label::all();
        return view('labels.index', compact('labels'));
    }

    public function create(): View
    {
        return view('labels.create');
    }

    public function store(Request $request): RedirectResponse
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

    public function show(): RedirectResponse
    {
        return redirect('labels');
    }

    public function edit(int $id): View
    {
        $label = Label::findOrFail($id);
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->validate($request, [
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

    public function destroy(int $id): RedirectResponse
    {
        $label = Label::findOrFail($id);
        $label->delete();
        flash(__('flash.success.f.delete', ['entity' => 'метка']), 'danger');
        return redirect()->route('labels.index');
    }
}
