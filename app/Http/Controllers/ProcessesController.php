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

        $process = new Process();
        $process->name = $data['name'];
        $process->department_id = $data['department_id'];
        $process->frequency_id = $data['frequency_id'];

        if(!empty($data['week_days'])) {
            $days = $data['week_days'];

            foreach($days as $day) {
                $process->$day = true;
            }
        }

        if(!empty($data['time'])) {
            $process->time = $data['time'];
        }

        if(!empty($data['range_start']) && !empty($data['range_end'])) {

            $inicio = \DateTime::createFromFormat('d/m/Y', $data['range_start']);
            $fim = \DateTime::createFromFormat('d/m/Y', $data['range_end']);

            $process->range_start = $inicio;
            $process->range_end = $fim;
        }

        $process->save();

        flash('Novo processo adicionado com sucesso.')->success()->important();

        return redirect()->route('processes');
    }

    public function copy()
    {

        try {

          $data = Req::all();

          $id = $data['process_id'];
          $name = $data['name'];

          if(empty($id) || empty($name)) {
              flash('Ocorreu um erro inesperado ao copiar o processo.')->error()->important();
              return redirect()->back();
          }

          $someProcess = Process::where('name', $name)->get();

          if($someProcess->isNotEmpty()) {
              flash('Já existe um processo com este mesmo nome.')->error()->important();
              return redirect()->back();
          }

          $process = Process::findOrFail($id);

          $pro = new Process();
          $pro->name = $name;
          $pro->department_id = $process->department_id;
          $pro->frequency_id = $process->frequency_id;
          $pro->monday = $process->monday;
          $pro->tuesday = $process->tuesday;
          $pro->wednesday = $process->wednesday;
          $pro->thursday = $process->thursday;
          $pro->friday = $process->friday;
          $pro->saturday = $process->saturday;
          $pro->sunday = $process->sunday;
          $pro->range_start = $process->range_start;
          $pro->range_end = $process->range_end;
          $pro->time = $process->time;
          $pro->save();

          $process->subprocesses->map(function($subprocess) use ($pro) {

              $sub = new SubProcesses();
              $sub->name = $subprocess->name;
              $sub->process_id = $pro->id;
              $sub->save();

              $subprocess->taskModels->map(function($task) use($sub) {

                $data = [
                    'name' => $sub->name,
                    'description' => $task->description,
                    'sub_process_id' => $sub->id,
                    'user_id' => $task->user_id,
                    'time' => $task->time,
                    'method' => $task->method,
                    'indicator' => $task->indicator,
                    'client_id' => $task->client_id,
                    'vendor_id' => $task->vendor_id,
                    'severity' => $task->severity,
                    'urgency' => $task->urgency,
                    'trend' => $task->trend,
                    'status_id' => Task::STATUS_PENDENTE,
                    'created_by' => Auth::user()->id,
                ];

                $newTask = new Task();

                foreach ($data as $key => $item) {
                    $newTask->$key = $item;
                }

                $newTask->save();

              });

          });

          return redirect()->route('processes');

        } catch(Exception $e) {
            flash('Ocorreu um erro inesperado ao copiar o processo.')->error()->important();
            return redirect()->back();
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
        $processes = SubProcesses::where('process_id', $id);

        return view('admin.processes.details')
            ->with('process', Process::findOrFail($id))
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
            ->with('process', Process::findOrFail($id))
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

        $process->frequency_id = $data['frequency_id'];

        if(!empty($data['week_days'])) {
            $days = $data['week_days'];

            foreach($days as $day) {
                $process->$day = true;
            }
        }

        if(!empty($data['time'])) {
            $process->time = $data['time'];
        }

        if(!empty($data['range_start']) && !empty($data['range_end'])) {

            $inicio = \DateTime::createFromFormat('d/m/Y', $data['range_start']);
            $fim = \DateTime::createFromFormat('d/m/Y', $data['range_end']);

            $process->range_start = $inicio;
            $process->range_end = $fim;
        }

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
