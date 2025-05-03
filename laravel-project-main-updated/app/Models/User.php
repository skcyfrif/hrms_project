<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getPermissionGroups()
    {
        $permission_groups = DB::table('permissions')
                                ->select('group_name')
                                ->groupBy('group_name')
                                ->get();

        return  $permission_groups;
    }//End Method

    public static function getPermissionByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
                    ->select('name' , 'id')
                    ->where('group_name' , $group_name)
                    ->get();

        return $permissions;

    } //End funciton

    public static function roleHasPermissions($role , $permissions)
    {
        $hasPermission = true ;


        foreach ($permissions as $permission) {
            if(!$role->hasPermissionTo($permission->name)){
                $hasPermission =false;
            }
        }

        return $hasPermission;
    } //End method

    // In the User model
public function subu()
{
    return $this->hasOne(Subu::class); // or hasMany if a user can have multiple employees
}


}
