<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mapper;
use App\User;
use App\Task;
use App\MapperTasks;
use Request as Req;
use Illuminate\Validation\Validator;

class MapperController extends Controller
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
        return view('admin.mappings.index')->with('mappings', Mapper::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mappings.create')
        ->with('users', User::all());
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

        if(empty($data['name'])) {

          $user = User::find($data['user']);

          $data['name'] = "Mapeamento Semana " . date('W') . " para " . $user->name;
        }

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
          'name' => 'required|max:255|unique:mappers',
          'user' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $hasMapperWithUser = Mapper::where('user_id', $data['user'])->where('active', 1)->first();

        if ($hasMapperWithUser) {
            return back()->withErrors('Já existe um mapeamento ativo para este usuário.');
        }

        $mapper = new Mapper();

        $mapper->name = $data['name'];
        $mapper->user_id = $data['user'];
        $mapper->save();

        return redirect()->action('MapperController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return view('admin.mappings.details')
        ->with('mapper', Mapper::findOrFail($id));
    }

    public function addTask($id)
    {
      $tasks = Task::where('status_id', 1)->where('mapper_id', null)->get();
      $mapper = Mapper::findOrFail($id);

      //dd($tasks->toArray());

        return view('admin.mappings.add-task')
        ->with('mapper', $mapper)
        ->with('tasks', $tasks);
    }

    public function addTaskStore()
    {
        $data = Req::all();

        foreach($data['ids'] as $item) {
            $mTask = Task::findOrFail($item);
            $mTask->mapper_id = $data['mapper'];
            $mTask->user_id = $data['user'];
            $mTask->save();
        }

        return redirect()->route('mapping', ['id' => $data['mapper']]);
    }

    public function removeTaskStore($id, $task)
    {
        $mTask = Task::findOrFail($task);
        $mTask->mapper_id = null;
        $mTask->save();

        return redirect()->route('mapping', ['id' => $id]);
    }

    public function start($id)
    {
        $mapper = Mapper::findOrFail($id);

        $mapper->active = true;
        $mapper->started_at = new \DateTime('now');

        $mapper->save();

        return redirect()->route('mapping', ['id' => $id]);
    }

    public function taskToDo($id)
    {
        $mapping = Mapper::findOrFail($id);
        $tasks = $mapping->tasks()->get();

        $resultado = $tasks->filter(function($task) {
            return $task->status_id == 1 || $task->status_id == 2;
        });

        $resultado = $resultado->map(function($task) {
            $link = route('task', ['id' => $task->id]);

            return [
                'nome' => "<a href={$link} class='text-navy'>".$task->description."</a>",
                'duracao' => HomeController::minutesToHour($task->time),
            ];
        });


      /*  $tasks = Task::where('mapper_id', $id)->get();*/

        return json_encode($resultado);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
