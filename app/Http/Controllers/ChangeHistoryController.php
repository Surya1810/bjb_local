<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ChangeHistoryController extends Controller
{
    public function index()
    {
        $changeHistory = DB::table('change_history')
            ->leftJoin('users', 'change_history.user_id', '=', 'users.id') // Pakai leftJoin agar tetap tampil jika user dihapus
            ->select('change_history.*', 'users.name as user_name')
            ->orderBy('change_history.created_at', 'desc')
            ->get()
            ->map(function ($history) {
                // Decode JSON changes
                $history->changes = json_decode($history->changes, true) ?? ['error' => 'Invalid JSON'];

                return $history;
            });

        return view('history.index', compact('changeHistory'));
    }
}
