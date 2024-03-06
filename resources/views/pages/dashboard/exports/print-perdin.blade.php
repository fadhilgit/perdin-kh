<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail perdin print</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 1%;
            padding: 30px;
            font-size: 12px;
        }

        .header-image {
            width: 300px;
            height: 60px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .border-top-left-right {
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
        .full-border {
            border: 1px solid black;
        }

        .p-5 {
            padding: 5px;
        }

        .vertical-top {
            vertical-align: top;
        }

        .bold {
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
        }
        .text-center {
            text-align: center;
        }

        .row  {
            margin-left:-5px;
            margin-right:-5px;
        }

        .column {
            float: right;
            width: 18%;
            padding: 5px;
        }

        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        .img-subject {
            width: 100%;
            height: auto;
        }

    </style>
</head>
<body>
    <table style="width: 100%">
        <tr>
            <td colspan="2" style="text-align: center">
                <img src="{{asset('')}}public/assets/images/logo-kwarsa2.png" alt="" class="header-image">
            </td>
        </tr>
        <tr>
           <td colspan="2" class="border-top-left-right p-5 title">LAPORAN PERJALANAN DINAS</td>
        </tr>
        @foreach ($perdins as $perdin)

        <tr>
            <td class="border-top-left-right p-5 vertical-top" width="50%">
                <table style="width: 100%">
                    <tr class="vertical-top">
                        <td class="p-5">Hari / Tanggal</td>
                        <td class="p-5">:</td>
                        <td class="p-5">
                            @if($perdin->start_date === $perdin->end_date)
                            {{\Carbon\Carbon::parse($perdin->start_date)->format('d/m/Y')}}
                            @else
                            {{\Carbon\Carbon::parse($perdin->start_date)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($perdin->end_date)->format('d/m/Y')}}
                            @endif

                        </td>
                    </tr >
                    <tr class="vertical-top">
                        <td class="p-5">Waktu</td>
                        <td class="p-5">:</td>
                        <td class="p-5">{{\Carbon\Carbon::parse($perdin->start_time)->format('H:i')}} - {{\Carbon\Carbon::parse($perdin->end_time)->format('H:i')}}</td>
                    </tr>
                    <tr class="vertical-top">
                        <td class="p-5">Tempat</td>
                        <td class="p-5">:</td>
                        <td class="p-5">{!! nl2br($perdin->place) !!}</td>
                    </tr>
                    <tr class="vertical-top">
                        <td class="p-5">No. Voucher</td>
                        <td class="p-5">:</td>
                        <td class="p-5">{{$perdin->no_voucher}}</td>
                    </tr>
                </table>
            </td>
            <td class="border-top-left-right p-5 vertical-top" width="50%">
                <table style="width: 100%">
                    <tr>
                        <td class="p-5 bold">Proyek :</td>
                    </tr>
                    <tr>
                        <td style="padding: 1px 5px 5px 5px">{!! nl2br($perdin->project) !!}</td>
                    </tr>
                    <tr>
                        <td class="p-5 bold">Agenda Perjalanan Dinas :</td>
                    </tr>
                    <tr>
                        <td style="padding: 1px 5px 5px 5px">{!! nl2br($perdin->agenda) !!}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border-top-left-right p-5 title" style="font-size: 12px;">PERSONEL YANG HADIR</td>
        </tr>
        <tr>
            <td class="p-5 bold border-top-left-right" style="text-align: center">PT. Kwarsa Hexagon</td>
            <td class="p-5 bold border-top-left-right" style="text-align: center">Lainnya</td>
        </tr>
        <tr>
            <td class="full-border p-5">
                {!! nl2br($perdin->personel_kwarsa) !!}
            </td>
            <td class="full-border p-5">
                {!! nl2br($perdin->personel_other) !!}
            </td>
        </tr>
        @endforeach
    </table>

    <table style="margin-top: 16px; width:100%">
        <tr>
            <td class="border-top-left-right p-5 bold" style="text-align: center" width="5%">No.</td>
            <td class="border-top-left-right p-5 bold" style="text-align: center" colspan="2" width="45%">Pokok Pembicaraan</td>
            <td class="border-top-left-right p-5 bold" style="text-align: center" width="15%">Rencana Tindak Lanjut</td>
            <td class="border-top-left-right p-5 bold" style="text-align: center" width="20%">Personel yang akan melaksanakan</td>
            <td class="border-top-left-right p-5 bold" style="text-align: center" width="15%">Target Penyelesaian</td>
        </tr>
        @foreach ($perdins as $perdin)
            @foreach ($perdin->perdinSubjectDiscussions as $subjectDiscussion)
            <tr>
                @php $noSubject = $loop->iteration @endphp
                <td class="full-border p-5" style="text-align: center">{{$loop->iteration}}</td>
                <td class="full-border p-5" colspan="2">{!! nl2br($subjectDiscussion->subject_discussion) !!}</td>
                <td class="full-border p-5">{{$subjectDiscussion->followup_plan}}</td>
                <td class="full-border p-5">{!! $subjectDiscussion->user_executor !!}</td>
                <td class="full-border p-5">{{$subjectDiscussion->completion_target}}</td>
            </tr>
            @if($subjectDiscussion->perdinSubjectImages)
            @foreach ($subjectDiscussion->perdinSubjectImages as $key => $image)
                @if($key % 2 == 0)
                    <tr>
                    @endif
                        <td class="full-border p-5" colspan="3" style="height: 120px; background-image: url('{{asset('')}}public/perdin_image/{{$image->image_name}}'); background-size: cover; background-repeat: no-repeat; background-position: center;"></td>

                @if($key % 2 != 0)

                </tr>
                @endif
                @if($subjectDiscussion->perdinSubjectImages->count() % 2 !== 0 && $loop->last)
                <td class="full-border p-5" colspan="3"></td>
                </tr>
                @endif
            @endforeach

            @endif

                @foreach ($subjectDiscussion->perdinSubSubjectDiscussion as $subSubjectDiscussion)
                <tr>
                    <td class="full-border p-5"></td>
                    <td class="full-border p-5" width="5%" style="text-align: center">{{$noSubject}}.{{$loop->iteration}}</td>
                    <td class="full-border p-5">{!! nl2br($subSubjectDiscussion->subject_discussion) !!}</td>
                    <td class="full-border p-5">{{$subSubjectDiscussion->followup_plan}}</td>
                    <td class="full-border p-5">{!! $subSubjectDiscussion->user_executor !!}</td>
                    <td class="full-border p-5">{{$subSubjectDiscussion->completion_target}}</td>
                </tr>
                @endforeach
            @endforeach
        @endforeach

    </table>

    <div style="width: 100%; text-align:right; margin-top:20px;">
        @foreach ($perdins as $perdin)
            Bandung, {{\Carbon\Carbon::parse($perdin->created_at)->isoFormat('D MMMM Y')}}
        @endforeach
    </div>

    {{-- Signature --}}
    <div class="row">
        <div class="column" style="page-break-inside: avoid;">
            <table style=" margin-top:10px; width:130px">
                <tr>
                    <td class="full-border p-5 text-center">Yang Melaporkan, </td>
                </tr>

                <tr>
                    @if($users->secondposition->name === "Supervisor")
                    <td class="full-border p-5 text-center">SPV. Sub U/K {{$users->subunitkerja->name}}</td>
                    @elseif($users->secondposition->name === "Staff")
                    <td class="full-border p-5 text-center">Staff Sub U/K {{$users->subunitkerja->name}}</td>
                    @elseif($users->secondposition->name === "Manajer Proyek")
                    <td class="full-border p-5 text-center">M/P Sub U/K {{$users->subunitkerja->name}}</td>
                    @elseif($users->secondposition->name === "Engineer")
                    <td class="full-border p-5 text-center">Engineer Sub U/K {{$users->subunitkerja->name}}</td>
                    @elseif($users->secondposition->name === "Manajer")
                    <td class="full-border p-5 text-center">Mjr. U/K {{$users->unitkerja->name}}</td>
                    @endif
                </tr>

                <tr>
                    <td class="border-top-left-right p-5 text-center" style="padding: 20px"><img src="" alt=""></td>
                </tr>

                <tr>
                    <td style="text-align: center; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;">{{$users->name}}</td>
                </tr>

            </table>
            </div>
    @foreach ($userChecking as $checking)
        <div class="column" style="page-break-inside: avoid;">
        <table style=" margin-top:10px; margin-right:5px; width:130px">
            <tr>
                <td class="full-border p-5 text-center">Diperiksa, </td>
            </tr>

            <tr>
                @if($checking->secondposition->name == "Manajer")
                <td class="full-border p-5 text-center">Mjr. U/K {{$checking->unitkerja->name}}</td>
                @elseif($checking->secondposition->name == "Supervisor")
                <td class="full-border p-5 text-center">SPV. Sub U/K {{$checking->subunitkerja->name}}</td>
                @elseif($checking->secondposition->name = "Manajer Proyek")
                <td class="full-border p-5 text-center">M/P. Sub U/K {{$checking->subunitkerja->name}}</td>
                @endif
            </tr>
            @php
                $isHasRecipient = \App\PerdinRecipient::where('user_id', $checking->id)->where('perdin_id', $dataPerdin->id)->first();
            @endphp
            <tr>
                @if($isHasRecipient)
                    @if($isHasRecipient->is_checked == 1)
                    <td class="border-top-left-right p-5 text-center">
                        <img src="{{asset('')}}/public/user_signature/{{$checking->signature}}" alt="" style="width: 32px; height:32px;">
                    </td>
                    @else
                    <td class="border-top-left-right p-5 text-center" style="padding: 20px"><img src="" alt=""></td>
                    @endif
                @else
                <td class="border-top-left-right p-5 text-center" style="padding: 20px"><img src="" alt=""></td>
                @endif
            </tr>

            <tr>
                <td style="text-align: center; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;">{{$checking->name}}</td>
            </tr>

        </table>
        </div>
    @endforeach

    </div>
    <div class="row" style="margin-top: 20px;">
    @foreach ($discoverUsers as $discoverUser)
        <div class="column" style="page-break-inside: avoid;">
            <table style="width:130px">
                <tr>
                    <td class="full-border p-5 text-center">Mengetahui, </td>
                </tr>

                <tr>
                    @if($discoverUser->secondposition->name === "Supervisor")
                    <td class="full-border p-5 text-center">SPV. Sub U/K {{$discoverUser->subunitkerja->name}}</td>
                    @elseif($discoverUser->secondposition->name = "Manajer")
                    <td class="full-border p-5 text-center">Mjr. U/K {{$discoverUser->unitkerja->name}}</td>
                    @elseif($discoverUser->secondposition->name = "Manajer Proyek")
                    <td class="full-border p-5 text-center">M/P. Sub U/K {{$discoverUser->unitkerja->name}}</td>
                    @endif
                </tr>
                @php
                $isHasDiscover = \App\PerdinRecipient::where('user_id', $discoverUser->id)->where('perdin_id', $dataPerdin->id)->first();
                @endphp
                <tr>
                    @if($isHasDiscover)
                        @if($isHasDiscover->is_checked == 1)
                        <td class="border-top-left-right p-5 text-center">
                            <img src="{{asset('')}}/public/user_signature/{{$discoverUser->signature}}" alt="" style="width: 32px; height:32px;">
                        </td>
                        @else
                        <td class="border-top-left-right p-5 text-center" style="padding: 20px"><img src="" alt=""></td>
                        @endif
                    @else
                    <td class="border-top-left-right p-5 text-center" style="padding: 20px"><img src="" alt=""></td>
                    @endif
                </tr>

                <tr>
                    <td style="text-align: center; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;">{{$discoverUser->name}}</td>
                </tr>

            </table>
        </div>
    @endforeach
    </div>

</body>
</html>
