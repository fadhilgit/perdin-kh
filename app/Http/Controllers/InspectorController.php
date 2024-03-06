<?php

namespace App\Http\Controllers;

use App\PerdinComment;
use App\PerdinRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Contracts\DataTable;

class InspectorController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = Auth()->user()->id;
        $recipients = PerdinRecipient::with('user', 'perdin', 'perdin.user')->where('user_id', $currentUserId)->get();
        if($request->ajax()) {
            return DataTables()->of($recipients)->make(true);
        }
        return view('pages.inspector.index');
    }

    public function comment(Request $request, $id)
    {
        $comments = PerdinComment::with('user')->where('comment_id', $id)->where('rule',$request->rule)->where('perdin_id',$request->perdin_id)->orderBy('id', 'desc')->get();

        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'message'=> 'Comment berhasil di fetching',
                'data' => $comments
            ]);
        }
    }

    public function postCommentPerdin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'comment' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        try {
            $userId = Auth()->user()->id;
            PerdinComment::create([
                'user_id' => $userId,
                'comment_id' => $request->comment_id,
                'perdin_id' => $request->perdin_id,
                'comment' => $request->comment,
                'rule' => $request->rule,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Komentar berhasil di kirim",
                'type' => "success"
            ]);

        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Komentar gagal di kirim",
                'type' => 'error'
            ]);

        }


    }
}
