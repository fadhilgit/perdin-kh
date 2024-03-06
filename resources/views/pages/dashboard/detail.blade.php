@extends('layouts.layout')
@section('content')
@push('styles')
<link href="{{ asset('') }}public/assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
    <style>
        .logo-table {
            height: 10%;
            width: 30%;
        }

        .td-align {
            vertical-align: top;
        }

        .dis-none {
            display: none;
        }
        #pokokPembicaraan:hover .dis-none  {
            display: block;
        }
        .fc {
            color: #a5a5a5;
        }
        .add a:link {
            color: #3cbade;
        }
        .add a:hover {
            color: #2f87a0;
        }

        .add:hover {
            background-color:#dfe5eb;
            cursor: pointer;
        }
        .custom-btn {
            display: inline-block;
            width: 1.4rem;
            height: 1.4rem;
            border-radius: 50%;
            text-align:center;
            cursor: pointer;
            border: none;
            background-color: #30495f;
            color: #fff;
            box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px,
            rgba(0, 0, 0, 0.07) 0px 2px 4px,
            rgba(0, 0, 0, 0.07) 0px 4px 8px,
            rgba(0, 0, 0, 0.07) 0px 8px 16px,
            rgba(0, 0, 0, 0.07) 0px 16px 32px,
            rgba(0, 0, 0, 0.07) 0px 32px 64px;
        }

        .custom-btn:hover {
            background-color: #3f6180;
        }

        .custom-btn:active {
            box-shadow: none;
        }
                /* Magnific Popup overlay z-index */
        .mfp-bg {
            z-index: 1060 !important; /* Adjust as needed */
        }

        .attachment {
            color: #747A80;
            font-weight: bold;
        }

        .attachment:hover {
            color: #505357;
        }

    </style>
@endpush

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Detail Perjalanan Dinas</h4>

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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title overflow-hidden">LAPORAN PERJALANAN DINAS</h4>
                            </div>
                            <div class="col-6" style="text-align: right">
                                @foreach ($dataPerdin as $data)
                                @if($data->user_id === Auth::user()->id)
                                    <a href="javascript:void(0)" id="btn-editPerdin" class="btn btn-sm btn-warning" data-id="{{$data->id}}"> <i class="fas fa-edit"></i>Edit </a>
                                    @if($data->attachment)
                                        <a href="javascript:void(0)" id="btn-attachment" class="btn btn-sm btn-warning" data-id="{{$data->id}}"> <i class="fas fa-edit"></i>Edit Lampiran</a>
                                    @endif
                                    <a href="{{url('/dashboard/detail/print')}}/{{$data->id}}" class="btn btn-sm btn-info"> <i class="fas fa-file-pdf"></i> Print </a>
                                    @if($data->status == "diperiksa")
                                        @if($recipientValidated->isEmpty())
                                        @if(! $data->perdinComment->isEmpty())
                                        <button id="btn-finish" class="btn btn-sm btn-success" data-id="{{$data->id}}"> Selesai</button>
                                        @endif
                                        @else
                                        <button id="btn-sendReview" class="btn btn-sm btn-success" data-id="{{$data->id}}" disabled> <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Proses pemeriksaan</button>
                                        @endif
                                    @elseif($data->status == null)
                                        <button id="btn-sendReview" class="btn btn-sm btn-success" data-id="{{$data->id}}"> <i class="fab fa-telegram-plane"></i> Kirim untuk di review</button>
                                    @endif
                                @else
                                    @if($perdinRecipient->is_checked == 1)
                                    <a href="javascript:void(0)" id="" class="btn btn-sm btn-outline-info waves-effect waves-light" data-id="{{$data->id}}"> Sudah di verifikasi </a>
                                    @else
                                    <a href="javascript:void(0)" id="btn-verifikasi" class="btn btn-sm btn-warning" data-id="{{$data->id}}"> Verifikasi Perjalanan Dinas </a>
                                    @endif

                                @endif

                                @endforeach
                            </div>
                        </div>

                        <p class="card-subtitle mb-4 font-size-13 overflow-hidden">
                            <div class="row">
                                @foreach ($dataPerdin as $data)
                                <div class="col-lg-6 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12 font-weight-bold">
                                                Hari / Tanggal :
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <?php
                                                    $start_dayName = \Carbon\Carbon::parse($data->start_date)->isoFormat('dddd');
                                                    $end_dayName = \Carbon\Carbon::parse($data->end_date)->isoFormat('dddd');
                                                ?>
                                                @if($data->start_date === $data->end_date)
                                                    <b>{{$start_dayName}}</b>, {{\Carbon\Carbon::parse($data->start_date)->format('d M Y')}}
                                                @else

                                                <b>{{$start_dayName}} - {{$end_dayName}}</b>, {{\Carbon\Carbon::parse($data->start_date)->format('d M Y')}} s/d {{\Carbon\Carbon::parse($data->end_date)->format('d M Y')}}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-6 col-sm-12 font-weight-bold">
                                                Waktu :
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                {{\Carbon\Carbon::parse($data->start_time)->format('H:i')}} s/d {{\Carbon\Carbon::parse($data->end_time)->format('H:i')}}
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-6 col-sm-12 font-weight-bold">
                                                Tempat :
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                {!! nl2br($data->place) !!}
                                            </div>
                                        </div>
                                        <div class="row mt-2 mb-2">
                                            <div class="col-lg-6 col-sm-12 font-weight-bold">
                                                No Voucher :
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                {{$data->no_voucher}}
                                            </div>
                                        </div>



                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 font-weight-bold">
                                            PROYEK :
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            {!! nl2br($data->project) !!}
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-12 col-sm-12 font-weight-bold">
                                            AGENDA PERJALANAN DINAS :
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            {!! nl2br($data->agenda) !!}
                                        </div>
                                    </div>
                                    <div class="row mt-5" >
                                        <div class="col-12" style="">
                                            <div class="row" >

                                                <div class="col-12 text-center">
                                                    @if($data->attachment)
                                                    <a href="{{asset('')}}/public/perdin_attachment/{{$data->attachment}}" class="attachment" target="_blank">
                                                    <img src="{{asset('')}}/public/assets/images/pdflogo.png" alt="" style="width: 80px; height:80px;">
                                                    <div class="mt-2">Klik disini untuk melihat lampiran</div>
                                                    </a>
                                                    @else
                                                    <a href="javascript:void(0)" class="attachment" id="btn-attachment" data-id="{{$data->id}}">
                                                        <img src="{{asset('')}}/public/assets/images/pdflogo.png" alt="" style="width: 80px; height:80px;">
                                                        <div class="mt-2">Klik disini untuk upload lampiran</div>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="col-12 text-center"></div>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class="col-12 mt-4">
                                    <div style="font-weight:bold;">PERSONEL YANG HADIR</div>
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-2">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="font-weight-bold">PT. Kwarsa Hexagon</div>
                                            <div>{!! nl2br($data->personel_kwarsa) !!}</div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="font-weight-bold">Lainya</div>
                                            <div>{!! nl2br($data->personel_other) !!}</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-6">
                                            @if(!$checker->isEmpty())
                                            <b>VERIFIKASI BOM YANG BERSANGKUTAN :</b>
                                            <ul>
                                                @foreach ($checker as $check)
                                                    <li>
                                                        {{$check->user->name}} @if($check->is_checked == 1)<span class="badge badge-soft-success">Sudah diverifikasi</span>  @else
                                                        <span class="badge badge-soft-danger">Belum di verifikasi</span>@endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            @if(!$discovers->isEmpty())
                                            <b>VERIFIKASI DARI MJR. DKA & MJR. PMO</b>
                                            <ul>
                                                @foreach ($discovers as $discover)
                                                <li>
                                                    {{$discover->user->name}} @if($discover->is_checked == 1)<span class="badge badge-soft-success">Sudah diverifikasi</span>  @else
                                                    <span class="badge badge-soft-danger">Belum di verifikasi</span>@endif
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title overflow-hidden">POKOK PEMBICARAAN</h4>
                    </div>
                    <div class="col-12">
                        <table class="w-100">
                            <thead style="background-color: #e2e2e2">
                            <tr style="text-align: center">
                                <td width="8%">#</td>
                                <td class="font-weight-bold px-2">No.</td>
                                <td colspan="2" class="font-weight-bold px-2">Pokok Pembicaraan</td>
                                <td class="font-weight-bold px-2">Rencana Tindak Lanjut</td>
                                <td class="font-weight-bold px-2">Personel yang melaksanakan</td>
                                <td class="font-weight-bold px-2">Target Penyelesaian</td>
                                <td class="font-weight-bold px-2">Foto</td>
                                <td width="8%">#</td>
                            </tr>
                            </thead>

                            @foreach ($dataPerdin as $data)
                                @foreach ($data->perdinSubjectDiscussions as $dataRelation)
                                    <tr id="pokokPembicaraan" style="border-bottom: 1px solid #cfcfcf;">

                                        <td class="px-4 text-center">
                                            @if($userPerdin === Auth::user()->id)
                                            <button class="custom-btn" id="pokokPembicaraanAction" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah sub pokok pembicaraan" data-id="{{$dataRelation->id}}">+</button>
                                            @endif
                                            </td>

                                        <td class="td-align text-center py-2">{{$loop->iteration}}.</td>
                                        <td colspan="2" class="td-align px-4 py-2 editable" data-field="subject_discussion">{!! nl2br($dataRelation->subject_discussion) !!}</td>
                                        <td class="td-align px-4 py-2 editable" data-field="followup_plan">{{$dataRelation->followup_plan}}</td>
                                        <td class="td-align px-4 py-2 editable" data-field="user_executor">{!! nl2br($dataRelation->user_executor) !!}</td>
                                        <td class="td-align px-4 py-2 editable" data-field="completion_target">{{$dataRelation->completion_target}}</td>
                                        <td class="px-4 py-2">

                                            @if($dataRelation->perdinSubjectImages->count() !== 0)
                                                <button class="btn btn-sm btn-dark" id="btn-showImage">Foto</button>
                                            @endif


                                        </td>
                                        <td class="px-4 text-center">
                                            @if($userPerdin === Auth::user()->id)
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" id="btn-inputImage" class="btn btn-secondary btn-sm btn-inputImage" data-id="{{$dataRelation->id}}" data-rule="pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Gambar">
                                                    <i class="mdi mdi-image-plus"></i>
                                                </button>

                                                <button type="button" id="btn-edit" class="btn btn-secondary btn-sm btn-edit" title="" data-id="{{$dataRelation->id}}" data-rule="pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Pokok Pembicaraan">
                                                    <i class="mdi mdi-file-document-edit-outline"></i>
                                                </button>
                                                <button type="button" id="btn-delete" class="btn btn-secondary btn-sm btn-delete" title=""  data-id="{{$dataRelation->id}}" data-rule="pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete / Cancel">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>

                                                @php
                                                    $comment = \App\PerdinComment::where('rule','pokok pembicaraan')->where('perdin_id', $data->id)->where('comment_id', $dataRelation->id)->first();
                                                @endphp
                                                    @if($comment)
                                                        <button href="javascript:void(0)" class="btn btn-secondary btn-sm btn-comment" id="btn-comment" data-id="{{$dataRelation->id}}" data-rule="pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Komentar"><i class="mdi mdi-comment-multiple-outline" style="color:red"></i> </button>
                                                    @endif

                                            </div>
                                            @else
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-comment" class="btn btn-secondary btn-sm btn-comment" title="" data-id="{{$dataRelation->id}}" data-rule="pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Beri komentar">
                                                        <i class="mdi mdi-file-document-edit-outline"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @foreach ($dataRelation->perdinSubSubjectDiscussion as $dataSubRelation)
                                        <tr id="pokokPembicaraan" style="border-bottom: 1px solid #cfcfcf">
                                            <td></td>
                                            <td></td>
                                            <td class="td-align text-center py-2">{{$loop->iteration}}.</td>
                                            <td class="td-align px-4 py-2 editable" data-field="subject_discussion">{!! nl2br($dataSubRelation->subject_discussion) !!}</td>
                                            <td class="td-align px-4 py-2 editable" data-field="followup_plan">{{$dataSubRelation->followup_plan}}</td>
                                            <td class="td-align px-4 py-2 editable" data-field="user_executor">{!! nl2br($dataSubRelation->user_executor) !!}</td>
                                            <td class="td-align px-4 py-2 editable" data-field="completion_target">{{$dataSubRelation->completion_target}}</td>
                                            <td class="px-4 py-2">
                                                @if($dataSubRelation->image_name)
                                                <a href="{{asset('')}}/public/perdin_image/{{$dataSubRelation->image_name}}" class=" btn btn-sm btn-dark"> Foto </a>
                                                @endif
                                            </td>
                                            <td class="px-4 text-center">
                                                @if($userPerdin === Auth::user()->id)
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-edit" class="btn btn-secondary btn-sm btn-edit" title="" data-id="{{$dataSubRelation->id}}" data-rule="sub pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Sub Pokok Pembicaraan">
                                                        <i class="mdi mdi-file-document-edit-outline"></i>
                                                    </button>
                                                    <button type="button" id="btn-delete" class="btn btn-secondary btn-sm btn-delete" title=""  data-id="{{$dataSubRelation->id}}" data-rule="sub pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete / Cancel">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </button>
                                                    @php
                                                    $subComment = \App\PerdinComment::where('rule','sub pokok pembicaraan')->where('perdin_id', $data->id)->where('comment_id', $dataSubRelation->id)->first();
                                                    @endphp
                                                    @if ($subComment)
                                                    <button type="button" id="btn-comment" class="btn btn-secondary btn-sm btn-comment" title="" data-id="{{$dataSubRelation->id}}" data-rule="sub pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="komentar">
                                                        <i class="mdi mdi-comment-multiple-outline" style="color:red"></i>
                                                    </button>
                                                    @endif

                                                </div>
                                                @else
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" id="btn-comment" class="btn btn-secondary btn-sm btn-comment" title="" data-id="{{$dataSubRelation->id}}" data-rule="sub pokok pembicaraan" data-toggle="tooltip" data-placement="top" title="" data-original-title="Beri komentar">
                                                        <i class="mdi mdi-file-document-edit-outline"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>


                                    @endforeach
                                    <tr id="formRow-{{$dataRelation->id}}" style="border-bottom: 1px solid #cfcfcf">
                                    </tr>

                                @endforeach
                            @endforeach
                            <tr id="addPokokPembicaraan" style="border-bottom: 1px solid #cfcfcf;">

                            </tr>
                            @if($userPerdin === Auth::user()->id)
                            <tr class="add fc">
                                    <td colspan="9" class="text-center px-4 py-2 ">
                                       <a href="javascript:void(0)" id="btn-addPokokPembicaraan" data-id="{{$dataId}}"> + Tambah pokok pembicaraan </a>
                                    </td>
                            </tr>
                            @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pages.dashboard.components.modal-editPerdin')
@include('pages.dashboard.components.modal-inputImage')
@include('pages.dashboard.components.modal-showImage')
@include('pages.dashboard.components.modal-attachment')
@include('pages.dashboard.components.modal-comment')
@endsection

@push('scripts')
    <script src="{{ asset('') }}public/assets/plugins/magnific-popup/jquery.magnific-popup.js"></script>
    <script>
        $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // plugins
        $('.popup-link').magnificPopup({
            type: 'image',
            gallery: {
            enabled: true
            },
            callbacks: {
            open: function() {
                // Adjust the z-index of the Magnific Popup container
                $('.mfp-wrap').css('z-index', 1061); // Make it higher than the Bootstrap modal
            }
            }
        });

        // end plugin

        // Handle pokokPembicaraan form
        $('table').on('click', '#btn-addPokokPembicaraan', function() {
            const id = $(this).data('id');
            $('#addPokokPembicaraan').html(`
            <form id="form-addPokokPembicaraan">
                <td style="text-align:center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                    <button type="submit" class="btn btn-secondary btn-sm waves-effect waves-light" id="btn-savePembicaraan" data-id="${id}">&#x2714;</button>
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" id="btn-dismisPembicaraan" >&#x2613</button>
                </div>
                </td>
                <td ></td>
                <td colspan="2" class="td-align px-4 py-2"><textarea class="w-100 form-control" id="first_subject_discussion" placeholder="Masukan pokok pembicaraan" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb" required></textarea>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-first_subject_discussion"></div>
                </td>
                <td class="td-align px-4 py-2"><textarea class="w-100 form-control" id="first_followup_plan" placeholder="Masukan rencana tindak lanjut" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb"></textarea></td>
                <td class="td-align px-4 py-2"><textarea class="w-100 form-control" id="first_user_executor" placeholder="Masukan personel yang melaksanakan" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb"></textarea></td>
                <td class="td-align px-4 py-2"><textarea class="w-100 form-control" id="first_completion_target" placeholder="Masukan target penyelesaian" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb"></textarea></td>
                </form>
            `)
        })

        $('table').on('click', '#btn-savePembicaraan', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            let subject_discussion = $('#first_subject_discussion').val();
            let followup_plan = $('#first_followup_plan').val();
            let user_executor = $('#first_user_executor').val();
            let completion_target = $('#first_completion_target').val();
            console.log(id, subject_discussion, followup_plan, user_executor, completion_target);
            $.ajax({
                url:`{{route('subjectStore')}}`,
                method: "POST",
                data: {
                    'id':id,
                    'subject_discussion': subject_discussion,
                    'followup_plan': followup_plan,
                    'user_executor': user_executor,
                    'completion_target': completion_target,
                },
                success: function(response) {
                    Swal.fire({
                        type: `${response.type}`,
                        icon: `${response.type}`,
                        title: `${response.message}`,
                        timer: 2000,
                        position: 'center',
                    }).then(function() {
                        window.location.reload();
                    });
                },
                error: function(error) {
                    if(error.responseJSON.subject_discussion) {
                            // Show alert
                        $('#alert-first_subject_discussion').removeClass('d-none');
                        $('#alert-first_subject_discussion').addClass('d-block');

                        // Add message
                        $('#alert-first_subject_discussion').html(error.responseJSON.subject_discussion[0]);
                        };
                }
            })
        })

        // End

        // Handle sub pokok pembicaraan form
        $('table').on('click', '#pokokPembicaraanAction', function() {
            const pokokPembicaraanId = $(this).data('id');

            // Define form-row-id
            let formRowId = `#formRow-${pokokPembicaraanId}`;

            // Update HTML of the specified form row
            $(formRowId).html(`
                <form id="form-${pokokPembicaraanId}" data-value="pokok">
                <td style="text-align:center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                    <button type="submit" class="btn btn-secondary btn-sm waves-effect waves-light" id="btn-saveSubPembicaraan" data-id="${pokokPembicaraanId}" >&#x2714;</button>
                    <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" id="btn-dismisSubPembicaraan" data-id="${pokokPembicaraanId}">&#x2613</button>
                </div>
                </td>
                <td></td>
                <td class="td-align text-center py-2"><input type="hidden" name="pokokPembicaraanId" id="pokokPembicaraanId" value="${pokokPembicaraanId}"  /></td>
                <td class="td-align px-4 py-2"><textarea class="w-100 form-control" id="subject_discussion" placeholder="Masukan sub pokok pembicaraan" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb" required></textarea>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-subject_discussion"></div>
                </td>
                <td class="td-align px-4 py-2"><textarea class="w-100 form-control" id="followup_plan" placeholder="Masukan rencana tindak lanjut" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb"></textarea></td>
                <td class="td-align px-4 py-2"><textarea class="w-100 form-control" id="user_executor" placeholder="Masukan personel yang melaksanakan" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb"></textarea></td>
                <td class="td-align px-4 py-2"><textarea class="w-100 form-control" id="completion_target" placeholder="Masukan target penyelesaian" style="border:none; border-bottom:1px solid black;  background-color:#dfe5eb"></textarea></td>
                </form>
            `);

        });

        $('table').on('click', '#btn-saveSubPembicaraan', function(e) {
            e.preventDefault();
            let pokokPembicaran = $('#pokokPembicaraanId').val();
            let subject_discussion = $('#subject_discussion').val();
            let followup_plan = $('#followup_plan').val();
            let user_executor = $('#user_executor').val();
            let completion_target = $('#completion_target').val();
            $.ajax({
                    url:'{{route('subSubjectStore')}}',
                    method:'POST',
                    data:{
                        'id':pokokPembicaran,
                        'subject_discussion': subject_discussion,
                        'followup_plan': followup_plan,
                        'user_executor': user_executor,
                        'completion_target': completion_target
                        },
                    success: function(response) {
                        Swal.fire({
                        type: `${response.type}`,
                        icon: `${response.type}`,
                        title: `${response.message}`,
                        timer: 2000,
                        position: 'center',
                    }).then(function() {
                        window.location.reload();
                    })
                    },
                    error: function(error) {
                        if(error.responseJSON.subject_discussion) {
                            // Show alert
                        $('#alert-subject_discussion').removeClass('d-none');
                        $('#alert-subject_discussion').addClass('d-block');

                        // Add message
                        $('#alert-subject_discussion').html(error.responseJSON.subject_discussion[0]);
                        };
                    }
                })
        })

        // End

        // Editable

        $('table').on('keydown', 'td.editable', function (e) {
    if (e.which === 13) {
        // Enter key pressed
        e.preventDefault();
        document.execCommand('insertText', false, '\n');
    }
});
        $('table').on('click', '#btn-edit', function(event) {
            const row = $(event.target).closest('tr');
            // Find editable fields within the row and make them editable
            row.find('td.editable').prop('contenteditable', true);

            const editButton = row.find('.btn-edit');
            const deleteButton = row.find('.btn-delete');

            editButton.text('Save').removeClass('btn-edit').addClass('btn-save');
            deleteButton.text('Cancel').removeClass('btn-delete').addClass('btn-dismiss');

        })

        $('table').on('click','.btn-save', function() {
            rowData = {}; // Collect updated data from the editable fields
                let token = $("meta[name='csrf-token']").attr("content");
                const dataId = $(this).data('id');
                const rule = $(this).data('rule');
                rowData._token = token;
                rowData.id = dataId;
                rowData.rule = rule;
                const row = $(event.target).closest('tr');

                row.find('td.editable').each(function() {
                    const fieldName = $(this).data('field');
                    let fieldValue = $(this).html(); // Use .html() to get content with <br>
                    console.log(fieldValue);
                    rowData[fieldName] = fieldValue;
                });

                $.ajax({
                    url:`{{url('/dashboard/detail/updateSubject')}}/${dataId}`,
                    method:'PUT',
                    data: rowData,
                    success: function(response) {
                        Swal.fire({
                        type: `${response.type}`,
                        icon: `${response.type}`,
                        title: `${response.message}`,
                        timer: 2000,
                        position: 'center',
                    }).then(function() {
                        window.location.reload();
                    })
                    },
                    erro: function(error) {
                        console.log('gagal')
                    }
                })
        })

        // Close Editable
        $('table').on('click', '#btn-delete', function() {
            const row = $(event.target).closest('tr');
            row.find('td.editable').prop('contenteditable', false);
            const editButton = row.find('.btn-save');
            const deleteButton = row.find('.btn-dismiss');

            editButton.html(`<i class="mdi mdi-file-document-edit-outline"></i>`).removeClass('btn-save').addClass('btn-edit');
            deleteButton.html(`<i class="mdi mdi-trash-can-outline"></i>`).removeClass('btn-dismiss').addClass('btn-delete');

        })


        $('table').on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");
            let rule = $(this).data('rule');
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: 'Ingin menghapus pokok pembicaraan dan sub pokok pembicaraan ini ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya, Hapus'
            }).then((result)=> {
                if(result.isConfirmed){
                    $.ajax({
                        url:`{{url('/dashboard/detail/deleteSubject')}}/${id}`,
                        type:'DELETE',
                        cache: false,
                        data: {
                            "_token":token,
                            "rule": rule,
                        },
                        success: function(response){
                            Swal.fire({
                                type: `${response.type}`,
                                icon: `${response.type}`,
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'top-right',

                            }).then(function(){
                                window.location.reload();
                            })
                        }
                    })
                }
            })
        })
        // End

        // remove form
        $('table').on('click', '#btn-dismisSubPembicaraan', function() {
            let pokokPembicaraanId = $(this).data('id');
            // Define form-row-id
            let formRowId = `#formRow-${pokokPembicaraanId}`;
            $(formRowId).empty();
        });

        $('table').on('click', '#btn-dismisPembicaraan', function() {
            $('#addPokokPembicaraan').empty();
        });

        // End

        $('body').on('click','#btn-sendReview', function() {
            const id = $(this).data('id');
            $('#btn-sendReview').attr('disabled', 'disabled');
                $('#btn-sendReview').html(`
                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            Loading...
                `);
            $.ajax({
                url: `{{url('/dashboard/detail/sendReview')}}/${id}`,
                method: 'POST',
                success: function(response) {
                    Swal.fire({
                        type: `${response.type}`,
                        icon: `${response.type}`,
                        title: `${response.message}`,
                        timer: 2000,
                        position: 'center',
                    }).then(function() {
                        window.location.reload();
                    })
                }
            })
        })

        $('body').on('click','#btn-finish', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `{{url('/dashboard/detail/finishRev')}}/${id}`,
                method: 'POST',
                success: function(response) {
                    Swal.fire({
                        type: `${response.type}`,
                        icon: `${response.type}`,
                        title: `${response.message}`,
                        timer: 2000,
                        position: 'center',
                    }).then(function() {
                        window.location.reload();
                    })
                }
            })
        })

        $('body').on('click', '#btn-verifikasi', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: 'Verifikasi perjalanan dinas ini ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya, Verifikasi'
            }).then((result) => {
                if(result.isConfirmed) {
                    $('#btn-verifikasi').attr('disabled', 'disabled');
                    $('#btn-verifikasi').html(`
                    <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                Loading...
                    `);
                    $.ajax({
                    url:`{{url('/dashboard/detail/verification')}}/${id}`,
                    method:'POST',
                    success: function(response) {
                        Swal.fire({
                                type: `${response.type}`,
                                icon: `${response.type}`,
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                position: 'top-right',
                        }).then(function() {
                            window.location.reload();
                        })
                    },
                    error: function(error) {

                    }
                })
                }
            })


        })
    });
    </script>
@endpush
