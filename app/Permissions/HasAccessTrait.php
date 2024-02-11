<?php

namespace App\Permissions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Am\Entities\UserRole;
use Modules\Am\Entities\UserRoleAcess;

trait HasAccessTrait
{

    public function hasAccess($menu)
    {

        // UserRoleAcess::where('userRoleId',Auth::user('role'))

        // return  UserRoleAcess::where('userRoleId',Auth::user()->role)->get();
        // return Auth::user()->role;

        $acess= DB::table('user_role_user_acess')
                ->join('useracess', 'user_role_user_acess.AccessId', '=', 'useracess.id')
                ->where('user_role_user_acess.userRoleId','=', Auth::user()->role)
                ->select('useracess.description', 'user_role_user_acess.status')
                ->get();

        foreach ($acess as $data){
            if($data->description == $menu){
                return $data->status;
            }
        }
    }

}
