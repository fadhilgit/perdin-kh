<?php

namespace App\Http\Controllers;

use App\Subunitkerja;

use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function getSubUk(Request $request, $id)
    {
        $subUk = Subunitkerja::where('unitkerja_id', $id)->get();
        if($request->ajax()){
            return response()->json([
                'success' => true,
                'message'=> 'Sub U/K berhasil di ambil',
                'data' => $subUk
            ]);
        }
    }
}
