<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'matricula';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'especialidad',
        'seguro_medico',
        'curp',
        'fecha_nacimiento',
        'grupo_id',
        
    ];
}
