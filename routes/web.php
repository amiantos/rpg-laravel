<?php

use App\Http\Controllers\CharacterController;
use App\Models\Character;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

/* Characters */

Route::get('/characters', function () {
    $user = Auth::user();
    return view('characters', [
        'characters' => $user->characters,
    ]);
})->middleware(['auth'])->name('characters');

Route::post('character-form', [CharacterController::class, 'store']);
Route::delete('character-destroy/{id}', [CharacterController::class, 'destroy']);

/* Playing */


Route::get('/play/{id}', function($id) {
    $user = Auth::user();
    $character = Character::findOrFail($id);

    if ($character->user_id != $user->id) {
        abort(403);
    }

    $room = $character->room;

    if (is_null($room)) {
        $floor = new Floor;
        $floor->character_id = $character->id;
        $floor->user_id = $user->id;
        $floor->save();

        $floor->generate(0,0,1);

        $character->room_id = $floor->first_room->id;
        $floor->first_room->visited = True;
        $floor->first_room->save();
        $character->save();
    }

    // $room->refresh();
    $character->refresh();

    $all_rooms = Room::where('character_id', $character->id)->where('z', 1)->get();

    return view('play', ['character' => $character, 'room' => $character->room, 'all_rooms' => $all_rooms]);
})->middleware(['auth'])->name('play');

require __DIR__.'/auth.php';
