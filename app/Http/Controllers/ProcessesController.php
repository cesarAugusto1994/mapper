<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Task;
use App\Models\Process;
use App\Models\Frequency;
use App\Models\SubProcesses;
use Illuminate\Http\Request;
use Request as Req;
use Auth;

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

          if(Auth::user()->isAdmin()) {

               if (Req::has('filter')) {
                     $process = Process::where('name', 'like', '%' . Req::get('filter') . '%')->get();
               } else {
                   $process = Process::all();
               }

          } else {

              if (Req::has('filter')) {
                    $process = Process::where('name', 'like', '%' . Req::get('filter') . '%')
                    ->where('department_id', Auth::user()->department_id)->get();
              } else {
                  $process =  Process::where('department_id', Auth::user()->department_id)->get();
              }

          }



        return view('admin.processes.index')->with('processes', $process);
    }

    public function toJson($id)
    {
        $process =  Process::find($id);
        return $process->toJson();
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
        $data = Req::all();

        $time = TaskController::hourToMinutes($data['time']);

        $process = new Process();
        $process->name = $data['name'];
        $process->department_id = $data['department_id'];
        $process->time = $time;
        $process->frequency_id = $data['frequency_id'];
        $process->save();

        if(isset($data['iname'])) {
            $iname = $data['iname'];
            $itime = $data['itime'];
            $ifrequency = $data['ifrequency'];
            $idepartment = $data['idepartment'];

            foreach ($iname as $key => $name) {

                $time = $time.$key;

                $time = TaskController::hourToMinutes($itime[$key]);

                $process = new Process();
                $process->name = $name;
                $process->department_id = $idepartment[$key];
                $process->time = $time;
                $process->frequency_id = $ifrequency[$key];
                $process->save();
            }
        }

        flash('Novo processo adicionado com sucesso.')->success()->important();

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
        $processes = SubProcesses::where('process_id', $id);

        return view('admin.processes.details')
            ->with('process', Process::find($id))
            ->with('subprocesses', $processes->get());
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

        flash('Edição do processo concluída com sucesso.')->success()->important();

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
