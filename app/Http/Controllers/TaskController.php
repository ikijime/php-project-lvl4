<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
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
        //$tasks = Task::with('creator', 'executor', 'status')->get();

        $tasks = QueryBuilder::for(Task::with('creator', 'executor', 'status'))
        ->allowedFilters([
            AllowedFilter::exact('status_id'),
            AllowedFilter::exact('author_id'),
            AllowedFilter::exact('assigned_to_id')
        ])
        ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
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
            'name' => 'required|unique:tasks',
            'description' => 'required',
            'status_id' => "required"
        ]);


        $newTask = new Task();
        $newTask->fill([
            'author_id' => Auth::id(),
            'name' => request('name'),
            'status_id' => request('status_id'),
            'description' => request('description'),
            'assigned_to_id' => request('assigned_to_id')
        ]);


        if ($newTask->save()) {
            $newTask->labels()->attach(request('labels'));
            flash('Task has been published', 'success');
            return redirect('/tasks');
        } else {
            flash('Something went wrong while creating task');
            return redirect('/tasks');
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
        $task = Task::findOrFail($id);
        $labels = $task->labels()->get();
        return view('tasks.show', compact('task', 'labels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
