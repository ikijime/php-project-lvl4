<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
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
    public function index(): View
    {
        $taskStatuses = TaskStatus::all();

        $usedStatuses = Task::select('status_id')->distinct()->get()->toArray();
        $usedStatusIds = collect($usedStatuses)->flatten(1);
        return view('taskStatuses.index', compact('taskStatuses', 'usedStatusIds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('taskStatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:task_statuses',
        ]);

        TaskStatus::create($request->only(['name']));

        flash(__('flash.success.m.create', ['entity' => 'статус']), 'success');
        return redirect('task_statuses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): RedirectResponse
    {
        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $status = TaskStatus::FindOrFail($id);
        return view('taskStatuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        request()->validate([
            'name' => 'required'
        ]);

        $task = TaskStatus::findOrFail($id);
        $task->update(['name' => request('name')]);

        flash(__('flash.success.m.change', ['entity' => 'статус']), 'success');
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $status = TaskStatus::findOrFail($id);

        if ($status) {
            $status->Delete();
            flash(__('flash.success.m.delete', ['entity' => 'статус']), 'danger');
        } else {
            flash(__('flash.error.m.delete', ['entity' => 'задача']));
        }

        return redirect()->route('task_statuses.index');
    }
}
