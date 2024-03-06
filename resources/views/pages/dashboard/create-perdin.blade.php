@extends('layouts.layout')
@section('content')
@push('styles')
<link href="{{ asset('') }}public/assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css">
@endpush
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">INPUT PERJALANAN DINAS</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Detail Perjalanan Dinas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-right position-relative">
                            <a href="#" class="dropdown-toggle h4 text-muted" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" class="dropdown-item">Action</a></li>
                                <li><a href="#" class="dropdown-item">Another action</a></li>
                                <li><a href="#" class="dropdown-item">Something else here</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a href="#" class="dropdown-item">Separated link</a></li>
                            </ul>
                        </div>
                        <h4 class="card-title overflow-hidden">Input Perjalanan Dinas</h4>
                        <form action="{{route('storePerdin')}}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-3 mb-3">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="end_date">Tanggal Berakhir</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="start_time">Waktu Mulai</label>
                                    <input type="time" id="start_time" name="start_time" class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="end_time">Waktu Berakhir</label>
                                    <input type="time" id="end_time" name="end_time" class="form-control">
                                </div>


                                <div class="col-6 mb-3">
                                    <label for="place">Tempat</label>
                                    <textarea id="place" name="place" class="form-control" placeholder="Masukan lokasi"></textarea>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="end_time">Nomer Voucher</label>
                                    <input type="text" id="no_voucher" name="no_voucher" class="form-control" placeholder="Masukan nomer voucher">
                                </div>

                                <div class="col-6">
                                    <label for="agenda">Agenda</label>
                                    <textarea id="agenda" name="agenda" class="form-control" placeholder="Masukan agenda"></textarea>
                                </div>

                                <div class="col-6">
                                    <label for="project">Proyek</label>
                                    <textarea id="project" name="project" class="form-control" placeholder="Masukan proyek"></textarea>
                                </div>


                                <div class="col-6 mb-3">
                                    <label for="personel_kwarsa">Personel PT. KH Yang Hadir</label>
                                    <textarea id="personel_kwarsa" name="personel_kwarsa" class="form-control" placeholder="Masukan Personel KH yang hadir"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="personel_other">Personel Lainnya</label>
                                    <textarea id="personel_other" name="personel_other" class="form-control" placeholder="Masukan Personel lainnya yang hadir"></textarea>
                                </div>



                                <div class="col-12">
                                    <button type="submit" class="btn btn-info" style="float: right"><i class="bx bx-save"></i> Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end card-body-->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

