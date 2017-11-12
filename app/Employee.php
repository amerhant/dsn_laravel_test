<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['surname','name','patronymic','position','year_birth','year_salary','currency'];
    protected $table = 'employees';
}
