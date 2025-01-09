<?php

namespace App\Http\Controllers;

use App\Models\User;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function __invoke(Centrifugo $centrifugo)
    {

//        $response = Http::withHeaders([
//            'Content-Type' => 'application/json',
//            'X-API-Key' => 'my_api_key',
//        ])
//            ->post('http://host.docker.internal:8000/api/publish', [
//            'channel' => 'channel',
//            'data' => ['value' => 2],
//        ]);
//        dd('q');
//        $centrifugo->publish('channel', ['message' => 'Hello world']);
//        User::factory(1)->create();



        $user = User::query()->first();
        auth()->login($user);
        $token = $centrifugo->generateConnectionToken((string)Auth::id(), 0, [
            'name' => Auth::user()->name,
        ]);

        return view('welcome', compact('token'));
    }
}
