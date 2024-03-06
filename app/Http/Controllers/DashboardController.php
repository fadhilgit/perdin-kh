<?php

namespace App\Http\Controllers;

use App\Imports\ImportPerdin;

use App\Perdin;
use App\PerdinComment;
use App\PerdinRecipient;
use App\PerdinSubjectDiscussion;
use App\PerdinSubSubjectDiscussion;
use App\PerdinSubjectImage;
use App\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Carbon;
use setasign\Fpdi\PdfParser\StreamReader;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    private $telegramLink;
    private $parseMode;

    public function __construct()
    {
        $this->telegramLink = ENV('TELEGRAM_LINK');
        $this->parseMode = ENV('PARSE_MODE');
    }

    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $dataPerdin = Perdin::where('user_id', $userId)
                                ->where(function($q){
                                    return $q->where('status', null)
                                                ->orWhere('status', 'diperiksa')
                                                ->orWhere('status', 'diketahui');
                                })->orderBy('start_date', 'DESC')->get();
        if($request->ajax()) {
            return DataTables()->of($dataPerdin)->make(true);
        };
        return view('index');
    }

    // public function review(Request $request, $id)
    // {
    //     $userId = Auth()->user()->id;
    //     return view('index');
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPerdin()
    {
        return view('pages.dashboard.create-perdin');
    }

    public function addPerjalananDinas()
    {
        return view('pages');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePerdin(Request $request)
    {
        $id = Str::uuid();

        DB::beginTransaction();
        try {

            $perdin = Perdin::create([
                'id' => $id,
                'user_id' => auth()->user()->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'project' => $request->project,
                'agenda' => $request->agenda,
                'place' => $request->place,
                'no_voucher' => $request->no_voucher,
                'personel_kwarsa' => $request->personel_kwarsa,
                'personel_other' => $request->personel_other,
            ]);
            DB::commit();
            return redirect('/dashboard/detail/'.$id);
        } catch(\Throwable $th) {

            DB::rollBack();

        }
    }

    public function storeSubject(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject_discussion' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors() ,422);
        }

        DB::beginTransaction();
        try {
            PerdinSubjectDiscussion::create([
                'perdin_id' => $request->id,
                'subject_discussion' => $request->subject_discussion,
                'followup_plan' => $request->followup_plan,
                'user_executor' => $request->user_executor,
                'completion_target' => $request->completion_target,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Data subjek berhasil di tambahkan",
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => true,
                'message' => "Data subjek gagal di tambahkan",
                'type' => "error",
                'error' => $th->getMessage()
            ]);
        }
    }

    public function storeSubSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_discussion' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator-> errors(), 422);
        }

        DB::beginTransaction();
        try {
            // Store Sub Subject
            PerdinSubSubjectDiscussion::create([
                'perdin_subject_discussion_id' => $request->id,
                'subject_discussion' => $request->subject_discussion,
                'followup_plan' => $request->followup_plan,
                'user_executor' => $request->user_executor,
                'completion_target' => $request->completion_target,
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Data sub subjek berhasil di tambahkan",
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => true,
                'message' => "Data sub subjek gagal di tambahkan",
                'type' => "error",
                'error' => $th->getMessage()
            ]);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $userId = auth()->user()->id;
        $dataPerdin = Perdin::with('perdinSubjectDiscussions.perdinSubSubjectDiscussion','perdinSubjectDiscussions.perdinSubjectImages','perdinComment')
                                ->where('id', $id)
                                ->get();
        $userPerdin = Perdin::where('id',$id)->value('user_id');
        $commentPerdin = PerdinComment::where('perdin_id',$id)->get();
        $perdinRecipient = PerdinRecipient::where('perdin_id', $id)->where('user_id', Auth()->user()->id)->first();
        $recipientValidated = PerdinRecipient::where('perdin_id', $id)->where('is_checked', null)->get();
        $checker = PerdinRecipient::with('user')
                                    ->where('perdin_id', $id)
                                    ->where('user_id','!=',16)
                                    ->where('user_id', '!=', 12)
                                    ->get();
        $discovers = PerdinRecipient::with('user')
                                    ->where('perdin_id', $id)
                                    ->where(function($q) {
                                        return $q->where('user_id', 16)
                                                    ->orWhere('user_id', 12);
                                    })->get();
        $dataId = $id;
        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data fethcing succcess',
                'data' => $dataPerdin
            ]);
        }
        return view('pages.dashboard.detail', compact('dataPerdin',
                                                        'dataId',
                                                        'userPerdin',
                                                        'commentPerdin',
                                                        'perdinRecipient',
                                                        'recipientValidated',
                                                        'checker',
                                                        'discovers'
                                                    ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'place' => 'required',
            'project' => 'required',
            'agenda' => 'required',
            'personel_kwarsa' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        try {
            Perdin::where('id', $id)->update([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'place' => $request->place,
                'no_voucher' => $request->no_voucher,
                'project' => $request->project,
                'agenda' => $request->agenda,
                'personel_kwarsa' => $request->personel_kwarsa,
                'personel_other' => $request->personel_other,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Data perdin berhasil di update",
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data perdin gagal di update',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function updateSubject(Request $request ,$id)
    {

        DB::beginTransaction();
        try {
            if($request->rule === "pokok pembicaraan") {
                PerdinSubjectDiscussion::where('id', $id)->update([
                    'subject_discussion' => $request->subject_discussion,
                    'followup_plan' => $request->followup_plan,
                    'user_executor' => $request->user_executor,
                    'completion_target' => $request->completion_target,
                ]);
            } else {
                PerdinSubSubjectDiscussion::where('id', $id)->update([
                    'subject_discussion' => $request->subject_discussion,
                    'followup_plan' => $request->followup_plan,
                    'user_executor' => $request->user_executor,
                    'completion_target' => $request->completion_target,
                ]);
            }


            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Data subject berhasil di update",
                'type' => 'success',
            ]);
        }catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data subject gagal di update',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);
        }

    }

    // Update image
    public function updateImage(Request $request, $id)
    {
        foreach ($request->file('image') as $imagePerdin) {
            // Validate and process each uploaded file here
            $validator = Validator::make(['image' => $imagePerdin], [
                'image' => 'required|mimes:jpeg,jpg,bmp,png|max:5128'
            ]);
            // Process the file upload for this iteration
        }

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        DB::beginTransaction();
        try {

            foreach($request->file('image') as $imagePerdin) {
                 $imageName = time(). "_" . $imagePerdin->getClientOriginalName();


            if($request->rule === "pokok pembicaraan") {

                    PerdinSubjectImage::create([
                        'perdin_subject_discussion_id' => $id,
                        'image_name' => $imageName
                    ]);
                    $imagePerdin->move(public_path('perdin_image'), $imageName);

            } else {

                $image = PerdinSubSubjectDiscussion::where('id', $id)->value('image_name');
                if(!$image) {
                    PerdinSubSubjectDiscussion::where('id', $id)->update([
                        'image_name' => $imageName
                    ]);
                    $imagePerdin->move(public_path('perdin_image'), $imageName);

                } else {
                    $exist_file = $image;
                    if (File::exists(public_path('perdin_image/' . $exist_file))) {
                        File::delete(public_path('perdin_image/' . $exist_file));
                        $image = null;
                    }

                    PerdinSubSubjectDiscussion::where('id', $id)->update([
                        'image_name' => $imageName
                    ]);

                    $imagePerdin->move(public_path('perdin_image'), $imageName);
                }
            }
            }


            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Gambar berhasil di update",
                'type' => 'success',
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gambar gagal di update',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);

        }
    }

    public function updateAttachment(Request $request, $id)
    {
        DB::beginTransaction();
        try{

            $attachmentName = time(). "_" . $request->attachment->getClientOriginalName();
            $attachment = Perdin::where('id', $id)->value('attachment');
                if(!$attachment) {
                    Perdin::where('id', $id)->update([
                        'attachment' => $attachmentName
                    ]);
                    $request->attachment->move(public_path('perdin_attachment'), $attachmentName);

                } else {
                    $exist_file = $attachment;
                    if (File::exists(public_path('perdin_attachment/' . $exist_file))) {
                        File::delete(public_path('perdin_attachment/' . $exist_file));
                        $attachment = null;
                    }

                    Perdin::where('id', $id)->update([
                        'attachment' => $attachmentName
                    ]);

                    $request->attachment->move(public_path('perdin_attachment'), $attachmentName);
                }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Attachment berhasil di update",
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Attachment gagal di update',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);

        }

    }

    public function sendReview(Request $request,$id)
    {

        DB::beginTransaction();
        try {

            $perdins = Perdin::where('id', $id)->update([
                'status' => 'diperiksa'
            ]);

            $dataPerdin = Perdin::with('user')->where('id', $id)->first();
            // 10 spv, 9 wakil manajer, 8 manajer
            $subunitkerja = $dataPerdin->user->subunitkerja_id;
            if($dataPerdin->user->secondposition_id == 10) {
                $userReview = User::where('unitkerja_id', $dataPerdin->user->unitkerja_id)
                                    ->where('secondposition_id', '<', 10)
                                    ->where('secondposition_id', '>=',8)
                                    ->get();
            }elseif($dataPerdin->user->secondposition_id == 8) {
                $userReview = User::where(function($q) {
                                return $q->where('id', 12)
                                            ->orWhere('id',16);
                            })->get();
            }elseif($dataPerdin->user->secondposition_id == 9) {
                $userReview = User::where('unitkerja_id', $dataPerdin->user->unitkerja_id)
                                    ->where('secondposition_id', '<', 9)
                                    ->where('secondposition_id', '>=',8)
                                    ->get();
            }elseif($dataPerdin->user->secondposition_id == 11) {
                $userReview = User::where('unitkerja_id', $dataPerdin->user->unitkerja_id)
                                    ->where('secondposition_id', '<', 11)
                                    ->where('secondposition_id', '>=',8)
                                    ->where(function($q) use($subunitkerja){
                                        return $q->where('subunitkerja_id',$subunitkerja)
                                                    ->orWhere('subunitkerja_id',null);
                                    })
                                    ->get();
            }elseif($dataPerdin->user->secondposition_id == 12) {
                $userReview = User::where('unitkerja_id', $dataPerdin->user->unitkerja_id)
                                    ->where('secondposition_id', '<', 12)
                                    ->where('secondposition_id', '>=',8)
                                    ->where(function($q) use($subunitkerja){
                                        return $q->where('subunitkerja_id',$subunitkerja)
                                                    ->orWhere('subunitkerja_id',null);
                                    })
                                    ->get();
            }elseif($dataPerdin->user->secondposition_id == 13) {
                $userReview = User::where('unitkerja_id', $dataPerdin->user->unitkerja_id)
                                    ->where('secondposition_id', '<', 12)
                                    ->where('secondposition_id', '>=',8)
                                    ->where(function($q) use($subunitkerja){
                                        return $q->where('subunitkerja_id',$subunitkerja)
                                                    ->orWhere('subunitkerja_id',null);
                                    })
                                    ->get();
            }

            foreach($userReview as $reviewer) {
                PerdinRecipient::create([
                    'perdin_id' => $dataPerdin->id,
                    'user_id' => $reviewer->id,
                ]);


                $response = Http::post($this->telegramLink, [
                    'parse_mode' => $this->parseMode,
                    'chat_id' => $reviewer->telegram_id,
                    'text' =>  ' 🛫 <b>Ajuan Laporan Perdin</b>' . PHP_EOL . PHP_EOL .
                                '<b>Kepada Yth,</b>' . PHP_EOL .
                                'Manajer Proyek, Supervisor dan Manajer' . PHP_EOL . PHP_EOL .
                                'Ajuan Lpaoran Perdin :' . PHP_EOL .
                                'Perihal : ' . $dataPerdin->agenda . PHP_EOL .
                                'Tanggal : ' . Carbon::parse($dataPerdin->start_date)->format('d/m/Y') . ' - '. Carbon::parse($dataPerdin->end_date)->format('d/m/Y') . PHP_EOL .
                                'Yang Melaporkan : ' . $dataPerdin->user->name . PHP_EOL . PHP_EOL .
                                'Mohon agar segera di tindak lanjuti untuk informasi lebih lanjut silahkan Klik Link berikut ini ...... , terima kasih.'
                ]);
            }



            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di kirim',
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal di kirim',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function finishRev(Request $request, $id)
    {
        DB:: beginTransaction();
        try{
            $userHasPerdin = Perdin::with('user')->where('id', $id)->first();
            $checker = [16,12];
            $checkerCount = count($checker);

            Perdin::where('id', $id)->update([
                'status' => 'diketahui'
            ]);

            for($i=0; $i<$checkerCount; $i++) {
                PerdinRecipient::create([
                    'user_id' => $checker[$i],
                    'perdin_id' => $id,
                ]);
                $user = User::where('id', $checker[$i])->first();
                            $response = Http::post($this->telegramLink, [
                                'parse_mode' => $this->parseMode,
                                'chat_id' => $user->telegram_id,
                                'text' =>  ' 🛫 <b>Laporan Perjalanan Dinas</b>' . PHP_EOL . PHP_EOL .
                                            '<b>Kepada Yth,</b>' . PHP_EOL .
                                            $user->name . PHP_EOL . PHP_EOL .

                                            'Ajuan Laporan Perdin :' . PHP_EOL .
                                            'Perihal : ' .$userHasPerdin->agenda . PHP_EOL .
                                            'Tanggal : ' . Carbon::parse($userHasPerdin->start_date)->format('d/m/Y'). ' - ' . Carbon::parse($userHasPerdin->end_date)->format('d/m/Y') . PHP_EOL .
                                            'Yang Melaporkan : ' . $userHasPerdin->user->name . PHP_EOL . PHP_EOL .
                                            'Mohon segera ditindak lanjuti untuk informasi lebih lanjut silahkan Klink Link berikut ini....... , terima kasih'
                            ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di revisi dan di kirimkan kepada Mjr. PMO dan Mjr. DKA',
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data gagal di revisi',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function verificationPerdin(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $userHasPerdin = Perdin::with('user')->where('id', $id)->first();
            PerdinRecipient::where('perdin_id', $id)
                        ->where('user_id', Auth()->user()->id)
                        ->update([
                            'is_checked' => 1
                        ]);

            $recipientCheck = PerdinRecipient::where('perdin_id', $id)
            ->where(function($q) {
                return $q->where('is_checked', null)
                            ->orWhere('is_checked', 0);
            })->get();

            $isHasCommentChecker = PerdinComment::with('user')->where('perdin_id',$id)->where('user_id', Auth()->user()->id)->get();
            $isHasComment = PerdinComment::with('user')->where('perdin_id',$id)->get();


            // Check after verif that has comment or not ?
            if(!$isHasCommentChecker->isEmpty()) {
                $response = Http::post($this->telegramLink, [
                    'parse_mode' => $this->parseMode,
                    'chat_id' => $userHasPerdin->user->telegram_id,
                    'text' =>  ' 🛫 <b>Revisi Laporan Perjalanan Dinas</b>' . PHP_EOL . PHP_EOL .
                                '<b>Kepada Yth,</b>' . PHP_EOL .
                                $userHasPerdin->user->name . PHP_EOL . PHP_EOL .
                                'Revisi Manajer Proyek, Supervisor, Manajer' . PHP_EOL .
                                'Laporan Perdin :' . PHP_EOL .
                                'Perihal :' . $userHasPerdin->agenda . PHP_EOL .
                                'Tanggal :'. Carbon::parse($userHasPerdin->start_date)->format('d/m/Y'). ' - ' . Carbon::parse($userHasPerdin->end_date)->format('d/m/Y') . PHP_EOL . PHP_EOL .
                                'Mohon segera ditindak lanjuti untuk informasi lebih lanjut silahkan Klink Link berikut ini....... , terima kasih'
                ]);
            }
            // End

            if($recipientCheck->isEmpty()) {
                if($isHasComment->isEmpty()) {
                    $isHasChecker = PerdinRecipient::where('perdin_id', $id)
                                                    ->where(function($q){
                                                        return $q->where('user_id', 16)
                                                                ->orWhere('user_id', 12);
                                                    })->get();

                    // Define id of mjr DKA & PMO;
                    if($isHasChecker->isEmpty()) {
                        $checker = [16,12];
                        $checkerCount = count($checker);
                        for($i=0; $i<$checkerCount; $i++) {
                            PerdinRecipient::create([
                                'user_id' => $checker[$i],
                                'perdin_id' => $id,
                            ]);
                            $user = User::where('id', $checker[$i])->first();
                            $response = Http::post($this->telegramLink, [
                                'parse_mode' => $this->parseMode,
                                'chat_id' => $user->telegram_id,
                                'text' =>  ' 🛫 <b>Laporan Perjalanan Dinas</b>' . PHP_EOL . PHP_EOL .
                                            '<b>Kepada Yth,</b>' . PHP_EOL .
                                            $user->name . PHP_EOL . PHP_EOL .

                                            'Ajuan Laporan Perdin :' . PHP_EOL .
                                            'Perihal : ' .$userHasPerdin->agenda . PHP_EOL .
                                            'Tanggal : ' . Carbon::parse($userHasPerdin->start_date)->format('d/m/Y'). ' - ' . Carbon::parse($userHasPerdin->end_date)->format('d/m/Y') . PHP_EOL .
                                            'Yang Melaporkan : ' . $userHasPerdin->user->name . PHP_EOL . PHP_EOL .
                                            'Mohon segera ditindak lanjuti untuk informasi lebih lanjut silahkan Klink Link berikut ini....... , terima kasih'
                            ]);
                        }

                        $response = Http::post($this->telegramLink, [
                            'parse_mode' => $this->parseMode,
                            'chat_id' => $userHasPerdin->user->telegram_id,
                            'text' =>  ' 🛫 <b>Perjalanan Dinas anda sedang diverifikasi oleh Mjr. DKA dan Mjr.PMO</b>' . PHP_EOL .
                                        '<b>Kepada Yth,</b>' . PHP_EOL .
                                        $userHasPerdin->user->name . PHP_EOL . PHP_EOL .
                                        'Ajuan Laporan Perdin :' . PHP_EOL .
                                        'Perihal : ' .$userHasPerdin->agenda . PHP_EOL .
                                        'Tanggal : ' . Carbon::parse($userHasPerdin->start_date)->format('d/m/Y'). ' - ' . Carbon::parse($userHasPerdin->end_date)->format('d/m/Y') . PHP_EOL .
                                        'Mohon segera ditindak lanjuti untuk informasi lebih lanjut silahkan Klink Link berikut ini....... , terima kasih'
                        ]);

                    } else {
                        $checkerChecked = PerdinRecipient::where('perdin_id', $id)
                                                            ->where(function($q) {
                                                                return $q->where('user_id', 16)
                                                                        ->orWhere('user_id', 12);
                                                            })
                                                            ->where('is_checked',1)
                                                            ->count();

                        if($checkerChecked == 2) {
                            Perdin::where('id', $id)->update([
                                'status' => 'disposisi'
                            ]);
                            $sekretariat = User::where('id', 1)->first();
                            $response = Http::post($this->telegramLink, [
                                'parse_mode' => $this->parseMode,
                                'chat_id' => $userHasPerdin->user->telegram_id,
                                'text' =>  ' 🛫 <b>Laporan Perdin Telah Di teruskan kepada sekretariat</b>' . PHP_EOL .
                                            '<b>Kepada Yth,</b>' . PHP_EOL .
                                            $userHasPerdin->user->name . PHP_EOL . PHP_EOL .
                                            'Ajuan Laporan Perdin :' . PHP_EOL .
                                            'Perihal : ' .$userHasPerdin->agenda . PHP_EOL .
                                            'Tanggal : ' . Carbon::parse($userHasPerdin->start_date)->format('d/m/Y'). ' - ' . Carbon::parse($userHasPerdin->end_date)->format('d/m/Y') . PHP_EOL .
                                            'Informasi lebih lanjut silahkan Klik Link berikut ini...... , terima kasih'
                            ]);

                            $response = Http::post($this->telegramLink, [
                                'parse_mode' => $this->parseMode,
                                'chat_id' => $sekretariat->telegram_id,
                                'text' =>  ' 🛫 <b>Ada Laporan Perdin Yang Harus Di disposisikan</b>' . PHP_EOL . PHP_EOL .
                                            '<b>Kepada Yth,</b>' . PHP_EOL .
                                            $sekretariat->name . PHP_EOL . PHP_EOL .
                                            'Ajuan Laporan Perdin :' . PHP_EOL .
                                            'Perihal : ' .$userHasPerdin->agenda . PHP_EOL .
                                            'Tanggal : ' . Carbon::parse($userHasPerdin->start_date)->format('d/m/Y'). ' - ' . Carbon::parse($userHasPerdin->end_date)->format('d/m/Y') . PHP_EOL .
                                            'Informasi lebih lanjut silahkan Klik Link berikut ini...... , terima kasih '
                            ]);
                        }
                    }
                } else {
                    $checkerChecked = PerdinRecipient::where('perdin_id', $id)
                                                            ->where(function($q) {
                                                                return $q->where('user_id', 16)
                                                                        ->orWhere('user_id', 12);
                                                            })
                                                            ->where('is_checked',1)
                                                            ->count();

                        if($checkerChecked == 2) {
                            Perdin::where('id', $id)->update([
                                'status' => 'disposisi'
                            ]);
                            $response = Http::post($this->telegramLink, [
                                'parse_mode' => $this->parseMode,
                                'chat_id' => $userHasPerdin->user->telegram_id,
                                'text' =>  ' 🛫 <b>Laporan Perdin Telah Di teruskan kepada sekretariat</b>' . PHP_EOL .
                                            '<b>Kepada Yth,</b>' . PHP_EOL .
                                            $userHasPerdin->user->name . PHP_EOL . PHP_EOL .
                                            'Ajuan Laporan Perdin :' . PHP_EOL .
                                            'Perihal : ' .$userHasPerdin->agenda . PHP_EOL .
                                            'Tanggal : ' . Carbon::parse($userHasPerdin->start_date)->format('d/m/Y'). ' - ' . Carbon::parse($userHasPerdin->end_date)->format('d/m/Y') . PHP_EOL .
                                            'Informasi lebih lanjut silahkan Klik Link berikut ini...... , terima kasih'
                            ]);
                        }
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Perjalanan Dinas berahasil di verifikasi",
                'type' => 'success'
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Perjalanan Dinas gagal di verifikasi",
                'error' => $th->getMessage(),
                'type' => 'error'
            ]);
        }


    }

    public function destroy($id)
    {
        //
    }

    public function destroySubject(Request $request ,$id)
    {
        DB::beginTransaction();
        try {
            if($request->rule === "pokok pembicaraan") {
                PerdinSubjectDiscussion::where('id',$id)->delete();
                PerdinSubSubjectDiscussion::where('perdin_subject_discussion_id', $id)->delete();
            } else {
                PerdinSubSubjectDiscussion::where('id', $id)->delete();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Data subject berhasil di hapus",
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data subject gagal di hapus',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function destroyImage($id)
    {
        DB::beginTransaction();
        try {
            PerdinSubjectImage::where('id', $id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Gambar berhasil di hapus",
                'type' => 'success',
            ]);
        } catch(\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gambar gagal di hapus',
                'type' => 'error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function importPerdin(Request $request)
    {
        DB::beginTransaction();
        try {
            $value = Excel::import(new ImportPerdin(), $request->file('file_perdin'));
            DB::commit();
            return redirect()->back()->with([
                'success' => 1,
                'message' => "Perjalanan Dinas Berhasil di import"
            ]);
        }catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with([
                'success' => 0,
                'message' => "Perjalanan Dinas Gagal di import"
            ]);
        }


    }


    // Print out
    public function printPerdin($id)
    {
        $dataPerdin = Perdin::where('id', $id)->first();

        $users = User::with('position', 'secondposition', 'unitkerja.subunitkerja')->where('id', $dataPerdin->user_id)->first();
        $subunitkerja = $users->subunitkerja_id;
        // if($users->secondposition_id === 10) {
        //     $userChecking = User::with('position', 'secondposition', 'unitkerja.subunitkerja')
        //                         ->where(function($q) {
        //                             return $q->where('secondposition_id', 8)
        //                                     ->orWhere('secondposition_id', 9);
        //                         })->where('unitkerja_id', $users->unitkerja_id)
        //                         ->get();
        // } elseif($users->secondposition_id === 8) {
        //     $userChecking = null;
        // }

        if($users->secondposition_id == 10) {
            $userChecking = User::with('position', 'secondposition', 'unitkerja.subunitkerja')
                                ->where('unitkerja_id', $users->unitkerja_id)
                                ->where('secondposition_id', '<', 10)
                                ->where('secondposition_id', '>=',8)
                                ->orderBy('secondposition_id', 'DESC')->get();
        }elseif($users->secondposition_id == 9) {
            $userChecking = User::with('position', 'secondposition', 'unitkerja.subunitkerja')
                                ->where('unitkerja_id', $users->unitkerja_id)
                                ->where('secondposition_id', '<', 9)
                                ->where('secondposition_id', '>=',8)
                                ->orderBy('secondposition_id', 'DESC')->get();
        }elseif($users->secondposition_id == 11) {
            $userChecking = User::with('position', 'secondposition', 'unitkerja.subunitkerja')
                                ->where('unitkerja_id', $users->unitkerja_id)
                                ->where('secondposition_id', '<', 11)
                                ->where('secondposition_id', '>=',8)
                                ->where(function($q) use($subunitkerja){
                                    return $q->where('subunitkerja_id',$subunitkerja)
                                                ->orWhere('subunitkerja_id',null);
                                })
                                ->orderBy('secondposition_id', 'DESC')->get();
        }elseif($users->secondposition_id == 12) {
            $userChecking = User::with('position', 'secondposition', 'unitkerja.subunitkerja')
                                ->where('unitkerja_id', $users->unitkerja_id)
                                ->where('secondposition_id', '<', 12)
                                ->where('secondposition_id', '>=',8)
                                ->where(function($q) use($subunitkerja){
                                    return $q->where('subunitkerja_id',$subunitkerja)
                                                ->orWhere('subunitkerja_id',null);
                                })
                                ->orderBy('secondposition_id', 'DESC')->get();
        }elseif($users->secondposition_id == 13) {
            $userChecking = User::with('position', 'secondposition', 'unitkerja.subunitkerja')
                                ->where('unitkerja_id', $users->unitkerja_id)
                                ->where('secondposition_id', '<', 12)
                                ->where('secondposition_id', '>=',8)
                                ->where(function($q) use($subunitkerja){
                                    return $q->where('subunitkerja_id',$subunitkerja)
                                                ->orWhere('subunitkerja_id',null);
                                })
                                ->orderBy('secondposition_id', 'DESC')->get();
        }else {
            $userChecking = [];
        }

        $discoverUsers = User::with('position', 'secondposition', 'unitkerja.subunitkerja')
                                ->where(function($q) {
                                return $q->where('id',12)
                                        ->orWhere('id', 16);
                                })->orderBy('secondposition_id', 'DESC')->get();

        $perdins = Perdin::with('perdinSubjectDiscussions.perdinSubSubjectDiscussion','perdinSubjectDiscussions.perdinSubjectImages')->where('id', $id)->get();
        // return view('pages.dashboard.exports.print-perdin', compact('perdins', 'users','userChecking', 'discoverUsers'));



        $exportPdfContent =  Pdf::loadView('pages.dashboard.exports.print-perdin', compact('perdins', 'users','userChecking', 'discoverUsers', 'dataPerdin'))->output();

        // Merge Export PDF
        $fpdi = new Fpdi();
        $numberOfPDF = $fpdi->setSourceFile(StreamReader::createByString($exportPdfContent));
        for ($pageNo = 1; $pageNo <= $numberOfPDF; $pageNo++) {
            $importedPage = $fpdi->importPage($pageNo);
            $fpdi->AddPage();
            $fpdi->useTemplate($importedPage);
        }

        if($dataPerdin->attachment) {
            $existingPdfPath = public_path('perdin_attachment/' . $dataPerdin->attachment);
            $existingPdfContent = file_get_contents($existingPdfPath);

            $existingPdfNumberOfPages = $fpdi->setSourceFile($existingPdfPath); //Count of page in file pdf local
        for ($pageNo = 1; $pageNo <= $existingPdfNumberOfPages; $pageNo++) {
            $importedPage = $fpdi->importPage($pageNo);
            $fpdi->AddPage();
            $fpdi->useTemplate($importedPage);
        }
        }


        // Output merged PDF
        $mergedPdfContent = $fpdi->Output('S'); // Get merged PDF content as string
        return response()->streamDownload(function () use ($mergedPdfContent) {
            echo $mergedPdfContent;
        }, 'PerjalananDinas.pdf');

    }
}
