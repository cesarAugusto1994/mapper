<?php

namespace App\Http\Controllers;

use App\Department;
use App\Task;
use App\Process;
use App\Frequency;
use Illuminate\Http\Request;
use Request as Req;

class ProcessesController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         if (Req::has('filter')) {
            $process = Process::where('name', 'like', '%' . Req::get('filter') . '%')->get();
        } else {
            $process = Process::all();
        }

        return view('admin.processes.index')->with('processes', $process);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.processes.create')
        ->with('departments', Department::all())
        ->with('frequencies', Frequency::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $process = Process::create(Req::all());

        return redirect()->route('process', ['id' => $process['id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = Task::where('process_id', $id);

        if (Req::has('filter')) {
            $tasks = Task::where('description', 'like', '%' . Req::get('filter') . '%');
        }

        return view('admin.processes.details')
            ->with('process', Process::find($id))
            ->with('tasks', $tasks->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.processes.edit')
            ->with('departments', Department::all())
            ->with('process', Process::find($id))
            ->with('frequencies', Frequency::all());
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
        $data = $request->request->all();

        $process = Process::findOrFail($id);

        $process->name = $data['name'];
        $process->department_id = $data['department_id'];
        //$process->frequency_id = $data['frequency_id'];
        $process->save();

        return redirect()->route('processes');
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
