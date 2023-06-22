<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Jobs\SendEmail;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tasks = Task::orderBy('created_at', 'desc')->paginate(5);
        return view('tasks.index', compact('tasks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('tasks.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskCreateRequest $request)
    {


        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $task = Task::create($data);

        dispatch(new SendEmail($task));

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if(!Gate::allows('edit', $task)) {
            abort(404);
        }

        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskCreateRequest $request, Task $task)
    {


        $data = $request->except(['_token', '_method', 'submit']);

        Task::where('id', $task->id)->update($data);

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if(!Gate::allows('delete', $task)) {
            abort(404);
        }
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
