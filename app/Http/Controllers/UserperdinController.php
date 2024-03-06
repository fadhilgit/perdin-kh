<?php

namespace App\Http\Controllers;

use App\Perdin;
use Illuminate\Http\Request;

class UserperdinController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $dataPerdin = Perdin::where('user_id', $userId)->where('status', '=', 'disposisi')->orderBy('start_date', 'DESC')->get();
        if($request->ajax()) {
            return DataTables()->of($dataPerdin)->make(true);
        };

        return view('pages.historyPerdin.index');
    }
}
