<?php

namespace App\Imports;

use App\Perdin;
use App\PerdinSubjectDiscussion;
use App\PerdinSubSubjectDiscussion;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpParser\ErrorHandler\Throwing;
use Stringable;
use Illuminate\Support\Str;

class ImportPerdin implements ToArray
{
    /**
    * @param Collection $collection
    */
    public function array(array $array)
    {

        $startDate = Carbon::createFromFormat('d/m/Y',$array[2][3])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y',$array[2][5])->format('Y-m-d');
        $startTime = Carbon::parse($array[3][3])->format('H:i:s');
        $endTime = Carbon::parse($array[3][5])->format('H:i:s');
        $project = $array[2][9];
        $agenda = $array[3][9];
        $place = $array[4][3];
        $no_voucher = $array[5][3];
        $personel_kwarsa = $array[8][0];
        $personel_other = $array[8][6];

        DB::beginTransaction();
        try {

            $id = Str::uuid();
            $perdin = Perdin::create([
                'id' => $id,
                'user_id' => auth()->user()->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'project' => $project,
                'agenda' => $agenda,
                'place' => $place,
                'no_voucher' => $no_voucher,
                'personel_kwarsa' => $personel_kwarsa,
                'personel_other' => $personel_other,
            ]);
            // This count for length of array
            $firstLoop = 19;
            for ($firstLoop; $firstLoop < count($array); $firstLoop++) {
                for ($nestedLoop = 0; $nestedLoop <= 13; $nestedLoop++) {
                    if ($nestedLoop === 1 && isset($array[$firstLoop][$nestedLoop])) {
                        $values = $array[$firstLoop][$nestedLoop];

                        $rencanaTindakLanjut = $array[$firstLoop][6];
                        $pelaksana = $array[$firstLoop][8];
                        $targetPenyelesaian = $array[$firstLoop][11];

                        // Input data to database PerdinSubjectDiscussion
                        $perdinSubjectDiscussion = PerdinSubjectDiscussion::create([
                            'perdin_id' => $id,
                            'subject_discussion' => $values,
                            'followup_plan' => $rencanaTindakLanjut,
                            'user_executor' => $pelaksana,
                            'completion_target' => $targetPenyelesaian
                        ]);

                    }

                    if ($nestedLoop === 3 && isset($array[$firstLoop][$nestedLoop])) {
                        $subValues = $array[$firstLoop][$nestedLoop];

                        $rencanaTindakLanjut = $array[$firstLoop][6];
                        $pelaksana = $array[$firstLoop][8];
                        $targetPenyelesaian = $array[$firstLoop][11];

                        // Input data to database PerdinSubSubjectDiscussion
                        if($perdinSubjectDiscussion) {
                            PerdinSubSubjectDiscussion::create([
                                'perdin_subject_discussion_id'=> $perdinSubjectDiscussion->id,
                                'subject_discussion' => $subValues,
                                'followup_plan' => $rencanaTindakLanjut,
                                'user_executor' => $pelaksana,
                                'completion_target' => $targetPenyelesaian
                            ]);
                        }
                    }
                }
            }
            DB::commit();

        } catch (\Exception $th) {
            DB::rollBack();
            dd($th->getMessage());

        }


    }



}
