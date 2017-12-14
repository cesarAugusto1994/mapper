<?php

namespace App\Http\Controllers;

use App\Department;
use App\Job;
use App\JobMessages;
use App\Process;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.jobs.index')->with('jobs', Job::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jobs.create')
            ->with('processes', Process::all())
            ->with('users', User::all())
            ->with('departments', Department::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        $tempo = \DateTime::createFromFormat('H:i', $data['time']);

        $hora = $tempo->format('H');
        $minutos = $tempo->format('i');

        $time = $minutos;

        if (!empty($hora)) {
            $time += $hora*60;
        }

        $data = [
            'description' => $data['description'],
            'process_id' => $data['process_id'],
            'user_id' => $data['user_id'],
            'frequency' => $data['frequency'],
            'time' => $time,
            'method' => $data['method'],
            'indicator' => $data['indicator'],
            'client_id' => $data['client_id'],
            'vendor_id' => $data['vendor_id'],
            'severity' => $data['severity'],
            'urgency' => $data['urgency'],
            'trend' => $data['trend'],
            'status_id' => Job::STATUS_PENDENTE,
            'created_by' => Auth::user()->id,
        ];

        Job::create($data);

        return redirect()->route('process', ['id' => $data['process_id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.jobs.details')
            ->with('job', Job::find($id))
            ->with('messages', JobMessages::where('job_id', $id)->get());
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
