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

    public function index(): View
    {
        $taskStatuses = TaskStatus::all();
        $usedStatuses = Task::select('status_id')->distinct()->get()->toArray();
        $usedStatusIds = collect($usedStatuses)->flatten(1);
        return view('taskStatuses.index', compact('taskStatuses', 'usedStatusIds'));
    }

    public function create(): View
    {
        return view('taskStatuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:task_statuses',
        ]);

        TaskStatus::create($request->only(['name']));

        flash(__('flash.success.m.create', ['entity' => 'статус']), 'success');
        return redirect('task_statuses');
    }

    public function show(int $id): RedirectResponse
    {
        return redirect()->route('task_statuses.index');
    }

    public function edit(int $id): View
    {
        $status = TaskStatus::FindOrFail($id);
        return view('taskStatuses.edit', compact('status'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        request()->validate([
            'name' => 'required'
        ]);

        $task = TaskStatus::findOrFail($id);
        $task->update(['name' => request('name')]);

        flash(__('flash.success.m.change', ['entity' => 'статус']), 'success');
        return redirect()->route('task_statuses.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $status = TaskStatus::findOrFail($id);
        $status->delete();
        flash(__('flash.success.m.delete', ['entity' => 'статус']), 'danger');
        return redirect()->route('task_statuses.index');
    }
}
