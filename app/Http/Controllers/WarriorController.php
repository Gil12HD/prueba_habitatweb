<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Warriors;

class WarriorController extends Controller
{
    /**
     * Muestra a todos los Guerreros
     * Ruta: '/warriors'
     * Tipo: POST
     * Retorna: Respuesta en formato Json con los guerreros a pelear
     */
    public function Warrior(Request $request)
    {
        $warriors = Warriors::GetWarriors($request);
        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $warriors
        ]);
    }
}
