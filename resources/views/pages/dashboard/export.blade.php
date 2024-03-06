@extends('layouts.layout')
@section('content')
@push('styles')
    <style>
        .logo-table {
            height: 10%;
            width: 30%;
        }

        .td-align {
            vertical-align: top;
        }

    </style>
@endpush

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Detail Perjalanan Dinas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="w-100" border="1">
                    <tr class="text-center">
                        <td colspan="6"><img src="{{asset('')}}public/assets/images/logo-kwarsa2.png" alt="" class="logo-table"></td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="6"><h4>LAPORAN PERJALANAN DINAS</h4></td>
                    </tr>
                    @foreach ($dataPerdin as $data)
                    <tr>
                        <td width="50%" colspan="3">
                            <table class="ml-2">
                                <tr>
                                    <td width="20%">Hari / Tanggal </td>
                                    <td>:</td>
                                    <td>{{$data->start_date}} - {{$data->end_date}}</td>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>:</td>
                                    <td>{{$data->start_time}} - {{$data->end_time}}</td>
                                </tr>
                                <tr>
                                    <td class="td-align">Tempat</td>
                                    <td class="td-align">:</td>
                                    <td class="td-align">{!! nl2br($data->place) !!}</td>
                                </tr>
                                <tr>
                                    <td>No Voucher</td>
                                    <td>:</td>
                                    <td>{{$data->no_voucher}}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="td-align" width="50%" colspan="3">
                            <table class="ml-2">
                                <tr>
                                    <td class="font-weight-bold">PROYEK :</td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! nl2br($data->project) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">AGENDA PERJALANAN DINAS:</td>
                                </tr>
                                <tr>
                                    <td>{!! nl2br($data->agenda) !!}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-center"><h4>PERSONEL YANG HADIR</h4></td>
                    </tr>
                    <tr>
                        <td class="pl-2 font-weight-bold" colspan="3">PT Kwarsa Hexagon</td>
                        <td class="pl-2 font-weight-bold" colspan="3">Lainnya</td>
                    </tr>
                    <tr>
                        <td class="pl-2 td-align" colspan="3">
                            {!! nl2br($data->personel_kwarsa) !!}
                        </td>
                        <td class="pl-2 td-align" colspan="3">
                            {!! nl2br($data->personel_other) !!}
                        </td>
                    </tr>
                    <tr>
                        <td>No.</td>
                        <td colspan="2">Pokok Pembicaraan</td>
                        <td>Rencana Tindak Lanjut</td>
                        <td>Personel yang melaksanakan</td>
                        <td>Target Penyelesaian</td>
                    </tr>
                        {{-- Relation --}}
                        @foreach ($data->perdinSubjectDiscussions as $dataRelation)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td colspan="2" class="pl-2">{!! nl2br($dataRelation->subject_discussion) !!}</td>
                            <td class="pl-2">{{$dataRelation->followup_plan}}</td>
                            <td class="pl-2">{{$dataRelation->user_executor}}</td>
                            <td class="pl-2">{{$dataRelation->completion_target}}</td>
                        </tr>
                            {{-- Sub Relation --}}
                            @foreach ($dataRelation->perdinSubSubjectDiscussion as $dataSubRelation)
                                <tr>
                                    <td></td>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="pl-2">{!! nl2br($dataSubRelation->subject_discussion) !!}</td>
                                    <td class="pl-2">{{$dataSubRelation->followup_plan}}</td>
                                    <td class="pl-2">{{$dataSubRelation->user_executor}}</td>
                                    <td class="pl-2">{{$dataSubRelation->completion_target}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush
