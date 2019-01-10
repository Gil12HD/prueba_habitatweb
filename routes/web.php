<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Ruta de inicio la cual regresa a todos los peladores de la Base de Datos
Route::get('/', function () {
    return redirect()->route('start');
    // $warriors = \App\Warriors::get();
    // return view('welcome', compact('warriors'));
});
// Ruta para obtener a los guerreros que van a pelear
Route::get('warriors', ['as' => 'start', 'uses' => 'WarriorController@GetWarriors']);
Route::post('warriors', ['as' => 'start.battle', 'uses' => 'WarriorController@Warrior']);
