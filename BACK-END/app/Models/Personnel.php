<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $table = 'personnel';
    protected $fillable =[
        'matricule',
        'date_embauche',
        'date_naissance',
        'is_delete',
        'id_user',
    ];

    static public function getMatricule()
    {
        return self::orderBy('matricule','desc')->first();
    }
    static public function getAllPersonnel()
    {
        return self::select('personnel.*','users.*','type_users.*','personnel.id as id_personnel')
        ->join('users','users.id','personnel.id_user')
        ->join('type_users','type_users.id','users.id_type_user')
        ->where('personnel.is_delete','=',0)
        ->get();
    }


    // static public function  getRecord()
    // {
    //     $return= self::select('assign_class_teacher.*', 'class.name as class_name', 'teacher.name as teacher_name', 'users.name as created_by_name')
    //             ->join('users as teacher', 'teacher.id', 'assign_class_teacher.teacher_id')
    //             ->join('class', 'class.id', 'assign_class_teacher.class_id')
    //             ->join('users', 'users.id', 'assign_class_teacher.created_by')
    //             ->where('assign_class_teacher.is_delete','=',0);
    //             if(!empty(Request::get('class_name'))){
    //                 $return=  $return->where('class.name','like','%'.Request::get('class_name').'%');
    //             }
    //             if(!empty(Request::get('teacher_name'))){
    //                 $return=  $return->where('teacher.name','like','%'.Request::get('teacher_name').'%');
    //             }
    //             if(!empty(Request::get('status'))){
    //                 $status = (Request::get('status') ==100) ? 0 : 1;
    //                 $return=  $return->where('assign_class_teacher.status','=',$status);
    //             }
    //             if(!empty(Request::get('date'))){
    //                 $return=  $return->whereDate('assign_class_teacher.created_at','=',Request::get('date'));
    //             }
    //             // $return=  $return->where('assign_class_teacher.is_delete','=',0)
    //             $return=   $return->orderBy('assign_class_teacher.id','desc')
    //             ->paginate(20);
    //     return $return;
    // }
}
