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
                    <h4 class="mb-0 font-size-18">Staff Perjalanan Dinas</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Staff Perjalanan Dinas</li>
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
                        <h4 class="card-title overflow-hidden">Verifikasi Perjalanan Dinas Staff</h4>


                        <div class="table-responsive">
                            <table class="table table-centered table-hover table-xl mb-0 w-100" id="table-perdin">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">No</th>
                                        <th class="border-top-0">Hari / Tanggal</th>
                                        <th class="border-top-0">Staff Input Perdin</th>
                                        <th class="border-top-0">Proyek</th>
                                        <th class="border-top-0">Agenda Perjalanan Dinas</th>
                                        <th class="border-top-0">Status Verifikasi</th>
                                        <th class="border-top-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div> <!-- end card-body-->
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.inspector.components.datatable-perdinstaff')
@push('scripts')
    {{-- After import action alert --}}
    <script>

    </script>
@endpush
@endsection

