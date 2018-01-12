<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;
use App\TaskLogs;
use App\Task;
use Illuminate\Http\Request;
use Request as Req;

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
        return view('admin.users.index')->with('users', User::all());
    }

    public static function getTaskPercentage($id)
    {
        $user = User::find($id);

        $total = $user->tasks->isNotEmpty() ? count($user->tasks->filter(function($task) {
            return $task->status_id != Task::STATUS_CANCELADO;
        })) : 1;

        $concludedTasks = count($user->tasks->filter(function($task) {
            return $task->status_id == Task::STATUS_FINALIZADO;
        }));

        $inProgressTasks = count($user->tasks->filter(function($task) {
            return $task->status_id == Task::STATUS_EM_ANDAMENTO;
        }));

        $porcent = round((($concludedTasks + ($inProgressTasks*0.50)) / $total) * 100);

        return $porcent;
    }

    public static function getTaskPercentageProgress($id)
    {
        $porcentage = self::getTaskPercentage($id);

        $classColor = 'progress-bar-primary';

        if(0 < $porcentage && 50 >= $porcentage) {
            $classColor = 'progress-bar-warning';
        } elseif (50 < $porcentage && 100 > $porcentage) {
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

        $user = new User();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->department_id = $data['department_id'];

        $user->save();

        //User::create(Req::all());

        return redirect()->action('UsersController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
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
        $user = User::find($id);

        $user->name = $request->request->get('name');
        $user->email = $request->request->get('email');
        $user->department_id = $request->request->get('department_id');
        $password = $request->request->get('password');

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->save();

        return redirect()->route('user', ['id' => $id]);
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
