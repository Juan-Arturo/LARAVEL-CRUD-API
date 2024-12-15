<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //Validar contenido de un JSON en una consulta SELECT
    public function handleValidateJSON($json)
    {
        if ($json->isEmpty()) {
            $response = [
                'message' => 'No hay registros',
                'status' => 200
            ];
            return response()->json($response);
        } else {
            return $json;
        }
    }

    //validacion de validator para los campos requeridos del front 
    public function handleValidationErrors($validator, $message = 'Error en la validación campos')
    {
        if ($validator->fails()) {
            return response()->json([
                'message' => $message,
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }

        return null; // Si no hay errores, devuelve null
    }

    //validacion de la creacion del registro
    public function handleCreationErrors($resource, $message = 'No se pudo crear el registro')
    {
        if (!$resource) {
            return response()->json([
                'message' => $message,
                'status' => 500,
            ], 500);
        }

        return null; // Si el recurso se creó correctamente, devuelve null
    }

    //validacion para buscar registro por id
    public function handleFindErrors($resource, $message = 'Registro no encontrado'){
        if(!$resource){
            return response()->json([
                'message' => $message,
                'status' => 404
            ], 404);
        }

        return null;
    }


}//en class controller
