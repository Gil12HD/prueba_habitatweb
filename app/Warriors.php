<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warriors extends Model
{
    protected $table = 'warriors';
    /**
     * Función scope para comunicación con el Controlador WarriorController para obtener los dos peleadores
     * Parámetros: La petición del cliente el la variable $request
     * Retorna: La variable $warriors con los dos guerreros
     */
    public function scopeGetWarriors ($query, $request){
        $ids = array(); // Array para obtener los ID`s de los peleadores
        array_push($ids, $request->id); // Se almacena el id del Cliente $request
        $rand = rand(1, 20);    // Se genera el id del peleador aleatoriamente
        if ($request->id == $rand) {    // Si el id random es igual al del Ciente se vuelve a generar y se almacena en el array $ids
            array_push($ids, rand(1,20));
        }
        array_push($ids, $rand);    // Si no se repite se almacena el id aleatorio
        $warriors = array();    // array para almacenar a los peleadores con base al id del usuario y el random
        foreach ($ids as $id) { // Se recorre el array de ids para buscarlos en la base de datos y obtener el primero que coincida con ese id
            array_push($warriors, Warriors::where('id',$id)
                ->first());
        }
        return $warriors;   // Se regresa el array con los dos guerreros obtenidos
    }

    /**
     * Función scope para comunicación con el Controlador WarriorController para obtener los dos peleadores
     * Parámetros: La petición del cliente el la variable $request
     * Retorna: La variable $warriors con los dos guerreros
     */
    public function scopeGetWarriorss ($query){
        $ids = array(); // Array para obtener los ID`s de los peleadores
        array_push($ids, rand(1, 20));    // Se genera el id del peleador aleatoriamente
        $rand = rand(1,20);
        if (in_array($rand, $ids)) {    // Si el id random es igual al del Ciente se vuelve a generar y se almacena en el array $ids
            array_push($ids, rand(1,20));
        }else {
            array_push($ids, $rand);    // Si no se repite se almacena el id aleatorio
        }
        $warriors = array();    // array para almacenar a los peleadores con base al id del usuario y el random
        foreach ($ids as $id) { // Se recorre el array de ids para buscarlos en la base de datos y obtener el primero que coincida con ese id
            array_push($warriors, Warriors::where('id',$id)
                ->first());
        }
        return $warriors;   // Se regresa el array con los dos guerreros obtenidos
    }
}