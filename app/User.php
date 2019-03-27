<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use App\Models\Task;
use App\Models\TaskLogs;
use App\Models\Department;
use Spatie\Permission\Traits\HasRoles;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, AuthenticationLogable;
    use HasRoleAndPermission;

    use Uuids;
    use LogsActivity;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login_soc', 'password_soc', 'id_soc'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['begin', 'end'];

    protected static $logAttributes = ['name', 'email', 'password', 'login_soc', 'password_soc', 'id_soc'];

    public function activities()
    {
        return $this->hasMany('App\Models\Activity', 'causer_id');
    }

    public function person()
    {
        return $this->belongsTo('App\Models\People', 'person_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function logs()
    {
        return $this->hasMany(TaskLogs::class);
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) ||
                 abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) ||
             abort(401, 'This action is unauthorized.');
    }
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
    *
    */
    public function isAdmin()
    {
        return $this->hasRole('Administrador');
    }
}
