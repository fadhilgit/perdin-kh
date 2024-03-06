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
                    <h4 class="mb-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <blockquote class="card-bodyquote mb-0">
                            <p>
                                Selamat datang, untuk menggunakan website / aplikasi e-Perdin user diwajibkan menggunakan format laporan yang disediakan.
                            </p>
                            <footer class="text-white-50"><a href="{{asset('')}}/public/format_import/Template_import_perdin.xlsx" class="btn btn-sm btn-light waves-effect"><i class="mdi mdi-file-export"></i> Download Format</a>
                            </footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
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
                        <div class="mb-4">
                            <button class="btn btn-sm btn-success" id="btn-importPerdin"><i class="mdi mdi-file-import"></i> Import Perjalanan Dinas</button>
                            <a href="{{route('createPerdin')}}" class="btn btn-sm btn-success" ><i class="mdi mdi-briefcase-plus"></i> Tambah Perjalanan Dinas</a>
                        </div>
                        <h4 class="card-title overflow-hidden">Perjalanan Dinas</h4>


                        <div class="table-responsive">
                            <table class="table table-centered table-hover table-xl mb-0 w-100" id="table-perdin">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">No</th>
                                        <th class="border-top-0">Hari / Tanggal</th>
                                        <th class="border-top-0">Proyek</th>
                                        <th class="border-top-0">Agenda Perjalanan Dinas</th>
                                        <th class="border-top-0">Status</th>
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
@include('components.datatable-dashboard')
@include('components.modal-import')
@push('scripts')
    {{-- After import action alert --}}
    <script>
        $(document).ready(function() {
            var success = "{{session('success')}}";
            var message = "{{session('message')}}";
            if(success !== '' & message !== '') {
                if(success == 1) {
                    Swal.fire({
                        type: `success`,
                        icon: `success`,
                        title: `${message}`,
                        timer: 2000,
                        toast: true,
                        position: 'top-right',
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                } else {
                    Swal.fire({
                        type: `error`,
                        icon: `error`,
                        title: `${message}`,
                        timer: 2000,
                        toast: true,
                        position: 'top-right',
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                }

            }
        })
    </script>
@endpush
@endsection

