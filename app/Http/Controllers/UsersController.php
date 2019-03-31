<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\TaskLogs;
use App\Models\Task;
use Illuminate\Http\Request;
use Request as Req;
use Illuminate\Validation\Validator;
use Auth;
use App\Models\People;

use App\Models\{Department,Module};
use App\Models\Department\Occupation;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

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
        if(!Auth::user()->hasPermission('view.usuarios')) {
            return abort(403, 'Unauthorized action.');
        }

        if(Auth::user()->isAdmin()) {
            $users =  User::all();
        } else {
            $users =  User::where('id', Auth::user()->id)->get();
        }

        $roles = Role::all();

        $departments = Department::all();
        $occupations = Occupation::where('department_id', $departments->first()->id)->get();

        return view('admin.users.index', compact('roles', 'users', 'departments', 'occupations'));
    }

    public function permissions($id)
    {
        $permissions = Permission::all();

        $modules = Module::all();

        $permissionsGroupedByModule = [];
/*
        foreach ($permissions as $key => $permission) {
            $module = Module::findOrFail($permission->module_id);
            if($module->children->isNotEmpty()) {
                $permissionsGroupedByModule[$module->name][] = $module->children()->get();
            }
        }
*/
        #dd($permissionsGroupedByModule);

        $user = User::uuid($id);

        return view('admin.users.permissions', compact('permissionsGroupedByModule', 'user', 'modules'));
    }

    public function grant($id, $permission)
    {
        $user = User::uuid($id);
        $user->attachPermission($permission);
        $user->save();

        return response()->json([
          'success' => true,
          'message' => 'Permissão concedida com sucesso.'
        ]);
    }

    public function revoke($id, $permission)
    {
        $user = User::uuid($id);
        $user->detachPermission($permission);
        $user->save();

        return response()->json([
          'success' => true,
          'message' => 'Permissão revogada com sucesso.'
        ]);
    }

    public function search(Request $request)
    {
        $id = $request->get('param');

        try {

          $person = People::uuid($id);

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $person
          ]);

        } catch(\Exception $e) {

          activity()
         ->causedBy($request->user())
         ->log('Erro ao buscar informações do usuário: '. $e->getMessage());

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);
        }

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
          /*'name' => 'required|max:255|unique:users',*/
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6',
          'roles' => 'required',
        ]);

        $permissions = Permission::pluck('id');

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $roleUser = Role::where("name", $data['roles'])->first();

        $department = Department::uuid($data['department_id']);
        $occupation = Occupation::uuid($data['occupation_id']);

        $person = People::create([
          'name' => $data['name'],
          'department_id' => $department->id,
          'occupation_id' => $occupation->id,
          'cpf' => $data['cpf']
        ]);

        $avatar = \Avatar::create($data['name'])->toBase64();

        $user = new User();
        $user->email = $data['email'];
        $user->nick = str_slug($data['name']);
        $user->password = bcrypt($data['password']);
        $user->person_id = $person->id;
        $user->avatar = $avatar;
        $user->change_password = true;
        $user->save();
        $user->roles()->attach($roleUser);

        if($roleUser->id == 1) {
            $user->syncPermissions($permissions);
        }

        $user->save();

        //$permissions = Permission::pluck('id');
        //$user->syncPermissions($permissions);

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
        if($request->has('id')) {
          $user = User::uuid($request->get('id'));
        } else {
          $user = $request->user();
        }

        $tasks = Task::where('user_id', $user->id)->limit(6)->orderBy('id', 'DESC')->get();

        $departments = Department::all();
        $departamentoAtual = $user->person->department;
        $occupations = Occupation::where('department_id', $departamentoAtual->id)->get();

        $activities = $user->activities;

        return view('admin.users.details', compact('occupations', 'departments', 'activities'))
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

        $person = $user->person;
        $person->name = $data['name'];
        $person->cpf = $data['cpf'];

        $department = Department::uuid($data['department_id']);
        $person->department_id = $department->id;

        $occupation = Occupation::uuid($data['occupation_id']);
        $person->occupation_id = $occupation->id;

        $person->save();

        $user->email = $data['email'];
        $user->save();

        return redirect()->route('user', ['id' => $user->uuid]);

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

        $user = User::uuid($id);

        $roleUser = Role::where("name", $data['roles'])->first();
/*
        $user->start_day = $data['begin'];
        $user->lunch = $data['lunch'];
        $user->lunch_return = $data['lunch_return'];
        $user->end_day = $data['end'];

        $user->weekly_workload = $data['weekly_workload'];
*/
        $user->login_soc = $data['login_soc'];
        $user->password_soc = $data['password_soc'];
        $user->id_soc = $data['id_soc'];

        $user->do_task = $data['do_task'];
        $user->active = $data['active'];

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->save();
        $user->roles()->attach($roleUser);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'As configurações do usuário foram alteradas com sucesso.'
        ]);

        return redirect()->route('user', ['id' => $id]);
    }

    public function updatePassword(Request $request, $id)
    {
        $data = $request->request->all();

        $user = User::uuid($id);

        $password = $data['password'];

        if (!empty($password)) {
            $user->password = bcrypt($password);
        }

        $user->save();

        notify()->flash('Sucesso!', 'success', [
          'text' => 'A senha do usuário foi alterada com sucesso.'
        ]);

        return redirect()->route('user', ['id' => $user->uuid]);
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

        //flash('A sua senha foi alterada com sucesso.')->success()->important();

        notify()->flash('Sucesso!', 'success', [
          'text' => 'A senha do usuário foi alterada com sucesso.'
        ]);

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
