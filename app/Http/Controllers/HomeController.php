<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\TaskLogs;
use Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::user()->id)->limit(5)->get();
        $concluded = $tasks->filter(function($task) {
            return $task->status_id == 3;
        });

        $spentTime = $tasks->sum('time');

        $spentTime = $tasks->map(function($task) {

            if ($task->status_id != 3) {
                return;
            }

            return (new \DateTime($task->begin))->diff((new \DateTime($task->end)))->format('%i');
        });

        $time = $tasks->map(function($task, $i) {
            return [
                  $i+1,
                  (int)$task->time
              ] ;
        });

        $time2 = $tasks->map(function($task, $i) {
            return [ $i+1,
                  (int)(new \DateTime($task->begin))->diff((new \DateTime($task->end)))->format('%i')
              ] ;
        });

        return view('home')
        ->with('logs', TaskLogs::limit(10)->orderBy('id', 'DESC')->get())
        ->with('tasks', $tasks)
        ->with('time', $spentTime->toJson())
        ->with('spent', $time->toJson())
        ->with('proposedTime', $time->toJson())
        ->with('spentTime', $spentTime->sum())
        ->with('concluded', $concluded);
    }
}
