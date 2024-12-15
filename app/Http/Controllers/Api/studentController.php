<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class studentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        //validamos si el json es vacio
        $studentsValidate = $this->handleValidateJSON($students);


        return response()->json($studentsValidate, 200);
    }

    public function store(Request $request)
    {

        //validacion de los campos en la peticion Request del front
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'seguro_medico' => 'nullable|string|max:255',
            'curp' => 'required|string|size:18|unique:students,curp', // CURP único y de 18 caracteres exactos
            'fecha_nacimiento' => 'nullable|date', // Validar como fecha
        ]);


        // Manejar errores de validación
        $validationResponse = $this->handleValidationErrors($validator, 'Campos de estudiante requeridos');
        if ($validationResponse) {
            return $validationResponse; // Retorna la respuesta JSON si hay errores
        }


        // Crear el estudiante
        $student = Student::create($request->all());


        // Manejar errores en la creación del estudiante
        $creationResponse = $this->handleCreationErrors($student, 'No se pudo crear al estudiante');
        if ($creationResponse) {
            return $creationResponse;
        }

        //Preparamos la respuesta
        $response = [
            'student' => $student,
            'message' => 'El estudiante se ha creado correctamente',
            'status' => 201
        ];

        return response()->json($response, 201);
    }

    public function show($id){
          $student = Student::find($id);

        //validacion de la busqueda por id de estudiante($student)
        $findStudent = $this->handleFindErrors($student, 'Estudiante no encontrado');
        if ($findStudent) {
            return $findStudent;
        }

        //Preparamos la respuesta
        $response = [
            'student' => $student,
            'message' => 'Estudiante encontrado',
            'status' => 200
        ];

        return response()->json($response, 200);
    }


    public function update($id, Request $request){
        $student = Student::find($id);
       

        //validacion de la busqueda por id de estudiante($student)
        $findStudent = $this->handleFindErrors($student, 'Estudiante no encontrado');
        if ($findStudent) {
            return $findStudent;
        }

       

        //validacion de los campos en la peticion Request del front
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'seguro_medico' => 'nullable|string|max:255',
            'curp' => ['required','string','size:18',Rule::unique('students')->ignore($student->matricula, 'matricula')], // CURP única sin tomar en cuenta la id del registro actual
            'fecha_nacimiento' => 'nullable|date', // Validar como fecha
        ]);

        // Manejar errores de validación
        $validationResponse = $this->handleValidationErrors($validator, 'Campos de estudiante requeridos');
        if ($validationResponse) {
            return $validationResponse; // Retorna la respuesta JSON si hay errores
        }

        

        //actualizar el estudiante
        $student->update($request->all());
        


        //Preparamos la respuesta
        $response = [
            'message' => 'El estudiante se ha actualizado correctamente',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($response, 200);
    }


    public function destroy($id){
        $student = Student::find($id);

        //validacion de la busqueda por id de estudiante($student)
        $findStudent = $this->handleFindErrors($student, 'Estudiante no encontrado');
        if ($findStudent) {
            return $findStudent;
        }

        //eliminar el estudiante
        $student->delete();

        //Preparamos la respuesta
        $response  = [
            'message' => 'El estudiante se ha eliminado correctamente',
            'status' => 200
        ];

        return response()->json($response, 200);
    }
    
}//end class studentController
