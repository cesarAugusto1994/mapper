<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskLogs;
use App\Models\Process;
use App\User;
use App\Models\Department;
use Auth;
use Redis;
use Redirect;

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
        if(!Auth::user()->active) {
          Auth::logout();
          return Redirect::route('login')->withErrors('Desculpe, mas o Usuário está desativado, entre em contato com o Administrador.');
        }

        $tasks = Task::where('user_id', Auth::user()->id)->limit(12)->orderBy('id', 'DESC')->get();

        $concluded = $tasks->filter(function($task) {
            return $task->status_id == Task::STATUS_FINALIZADO;
        });

        $date = new \DateTime('now');

        $concludedInThisWeek = $tasks->filter(function($task) use($date) {

            $dateWeekNumber = $date->format('w') - 1;

            if($dateWeekNumber > 0) {
                $date->modify("- {$dateWeekNumber} days");
            }

            return $task->status_id == Task::STATUS_FINALIZADO && $task->end >= $date->format(\DateTime::ISO8601);
        });

        $concludedInThisMount = $tasks->filter(function($task) use($date) {

            $dateDaysNumber = $date->format('d');

            if($dateDaysNumber != 1) {
                $date->modify("- {$dateDaysNumber} days");
            }

            return $task->status_id == Task::STATUS_FINALIZADO && $task->end >= $date->format(\DateTime::ISO8601);
        });

        $concludedInThisMountWithDelay = $concludedInThisMount->filter(function($task) {
            return $task->spent_time > $task->time;
        });

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

        $peddingTasks = $tasks->filter(function($task) {
            return $task->status->id == Task::STATUS_PENDENTE;
        });

        $percentMount = self::getPercetageDoneTasks($concludedInThisMount, $concludedInThisMountWithDelay);

        return view('home')
        ->with('processes', Process::all())
        ->with('users', User::all())
        ->with('departments', Department::all())
        ->with('logs', TaskLogs::limit(6)->orderBy('id', 'DESC')->get())
        ->with('tasks', $tasks)
        ->with('peddingTasks', $peddingTasks)
        ->with('time', $spentTime->toJson())
        ->with('spent', $time->toJson())
        ->with('proposedTime', $time->toJson())
        ->with('spentTime', $spentTime->sum())
        ->with('concluded', $concluded)
        ->with('concludedInThisWeek', $concludedInThisWeek)
        ->with('concludedInThisMount', $concludedInThisMount)
        ->with('concludedInThisMountWithDelay', $concludedInThisMountWithDelay)
        ->with('percentMount', $percentMount);
    }

    public static function getPercetageDoneTasks($concludedInThisMount, $concludedInThisMountWithDelay)
    {
        return round((count($concludedInThisMountWithDelay)/ !empty($concludedInThisMount) ? count($concludedInThisMount) : 1) * 100, 2);
    }

    public static function minutesToHour($time)
    {
        $hours = floor($time / 60);
        $minutes = ($time % 60);

        $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

        if ($hours < 10) {
           $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
        }

        return "{$hours}:{$minutes}:00";
    }

    public static function intToHour($hour)
    {
        if(empty($hour)) {
            return;
        }

        return "{$hour}:00:00";
    }
}
