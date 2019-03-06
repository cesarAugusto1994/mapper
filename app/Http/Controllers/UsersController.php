<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Department;
use App\Models\TaskLogs;
use App\Models\Task;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Request as Req;
use Illuminate\Validation\Validator;
use Auth;

class UsersController extends Controller
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
        $users = User::all();

        if(Auth::user()->isAdmin()) {
            $users =  User::all();
        } else {
            $users =  User::where('id', Auth::user()->id)->get();
        }

        return view('admin.users.index')->with('users', $users);
    }

    public static function getTaskPercentage($id)
    {
        $user = User::find($id);

        $total = $user->tasks->isNotEmpty() ? count($user->tasks->filter(function($task) {
            return $task->status_id != Task::STATUS_CANCELADO && !$task->is_model;
        })) : 1;

        $concludedTasks = count($user->tasks->filter(function($task) {
            return $task->status_id == Task::STATUS_FINALIZADO && !$task->is_model;
        }));

        $inProgressTasks = count($user->tasks->filter(function($task) {
            return $task->status_id == Task::STATUS_EM_ANDAMENTO && !$task->is_model;
        }));

        if($total <= 0) {
          $total = 1;
        }

        if(!$inProgressTasks && !$inProgressTasks && !$total) {
          return 0;
        }

        if(!$concludedTasks) {
          $inProgressTasks = $inProgressTasks*0.50;
        }

        $porcent = round((($concludedTasks + $inProgressTasks) / $total) * 100);

        return $porcent;
    }

    public static function getTaskPercentageProgress($id)
    {
        $porcentage = self::getTaskPercentage($id);

        $classColor = 'progress-bar-primary';

        if(0 < $porcentage && 50 >= $porcentage) {
            $classColor = 'progress-bar-warning';
        } elseif (50 < $porcentage && 100 >= $porcentage) {
            $classColor = 'progress-bar-primary';
        }

        return $classColor;
    }

    public static function getLatestTask($id)
    {
        $tasks = Task::where('user_id', $id)->where('status_id', Task::STATUS_EM_ANDAMENTO)->orderBy('id', 'DESC')->get();

        $horaAtual = new \DateTime('now');

        $lastests = $tasks->filter(function($task) use($horaAtual) {

          $horaCorte = new \DateTime($task->begin);

          $diff = $horaAtual->diff($horaCorte);
          $segundos = $diff->s + ($diff->i * 60) + ($diff->h * 60);

          $remainTime = ($task->time*60) - $segundos;

          return $task->time > $remainTime;

        });

        if($lastests->isEmpty()) {
          return '';
        }

        return 'Tarefa Atrasada';
    }

    public static function getTodayLogs($id)
    {
        $logs = TaskLogs::where('user_id', $id)
        ->where('created_at', '>', (new \DateTime('now'))->format('Y-m-d') . ' 00:00:00')
        ->orderBy('id', 'DESC')
        ->take(3);

        return $logs->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create')->with('departments', Department::all());
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

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
          'name' => 'required|max:255|unique:users',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6',
          'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $roleUser = Role::where("name", $data['roles'])->first();

        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->department_id = $data['department_id'];
        $user->save();
        $user->roles()->attach($roleUser);

        flash('Novo usuário adicionado com sucesso.')->success()->important();

        return redirect()->action('UsersController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $tasks = Task::where('user_id', $user->id)->limit(6)->orderBy('id', 'DESC')->get();

        return view('admin.users.details')
        ->with('user', $user)
        ->with('tasks', $tasks)
        ->with('logs', TaskLogs::where('user_id', $user->id)->limit(6)->orderBy('id', 'DESC')->get())
        ->with('departments', Department::all());
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAvatar($id)
    {
        return view('admin.users.avatar')->with('user', User::find($id));
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

        $user = User::findOrFail($id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->department_id = $data['department_id'];

        $user->save();

        return redirect()->route('user', ['id' => $id]);

        flash('As informações do usuário foram alteradas com sucesso.')->success()->important();
    }

    public function updateConfigs(Request $request, $id)
    {
        $data = $request->request->all();

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
          'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);

        $roleUser = Role::where("name", $data['roles'])->first();

        $user->start_day = $data['begin'];
        $user->lunch = $data['lunch'];
        $user->lunch_return = $data['lunch_return'];
        $user->end_day = $data['end'];

        $user->weekly_workload = $data['weekly_workload'];

        $user->do_task = $data['do_task'];
        $user->active = $data['active'];

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->save();

        $user->roles()->attach($roleUser);

        flash('As configurações do usuário foram alteradas com sucesso.')->success()->important();

        return redirect()->route('user', ['id' => $id]);
    }

    public function updatePassword(Request $request, $id)
    {
        $data = $request->request->all();

        $user = User::findOrFail($id);


        $password = $data['password'];

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->save();

        flash('A senha do usuário foi alterada com sucesso.')->success()->important();

        return redirect()->route('user', ['id' => $id]);
    }

    public function updatePasswordFirstAccess(Request $request, $id)
    {
        $data = $request->request->all();

        $user = User::findOrFail($id);

        $password = $data['password'];

        if (!empty($password)) {
            $user->password = bcrypt($password);
            $user->change_password = false;
        }

        $user->save();

        flash('A sua senha foi alterada com sucesso.')->success()->important();

        return redirect()->back();
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadAvatar($id, $avatar)
    {
        $user = User::find($id);

        $src = 'admin/avatars/'.$user->avatar;

        if ($user->avatar) {
            if (file_exists($src)) {
                unlink($src);
            }
        }

        $user->avatar = $avatar;

        $user->save();

        return redirect()->route('user', ['id' => $id]);
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
