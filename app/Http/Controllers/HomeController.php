<?php

namespace App\Http\Controllers;

use App\Models\Agunan;
use App\Models\Document;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

use function React\Promise\all;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all()->except(1)->count();
        $documents = Document::all()->count();
        $agunans = Agunan::all()->count();;
        $tags = Tag::where('status', 'available')->count();

        return view('home.dashboard', compact('users', 'documents', 'agunans', 'tags'));
    }
}
