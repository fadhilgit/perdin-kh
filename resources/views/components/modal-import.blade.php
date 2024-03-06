<div class="modal fade show" id="modal-importPerdin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bx bx-mail-send"></i> Import Perjalanan Dinas</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card text-white bg-dark">
                    <div class="card-body">
                        <blockquote class="card-bodyquote mb-0">
                            <p>
                                <b>Note:</b><br>
                                1. Data yang di import harus sesuai format yang di berikan sistem. <br>
                                2. Untuk isian yang berisikan waktu / tanggal maka harus di tambahkan <b>'</b>, untuk contoh: " '12/01/2024 " .
                            </p>
                            <footer class="blockquote-footer text-white-50">Sekian, <cite title="Source Title">Bila terjadi error atau bingung silahkan hubungi U/K PTR</cite>
                            </footer>
                        </blockquote>
                    </div>
                </div>

                <form method="post" action="{{route('dashboard-import')}}" enctype="multipart/form-data" id="formImport">
                    @csrf
                    <div class="mb-2">
                        <label for="file_perdin" class="col-form-label">File<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file_perdin" name="file_perdin" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-file_perdin"></div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light"
                    data-dismiss="modal">Tutup</button>
                <button type="submit" id="btn-saveImport" class="btn btn-primary waves-effect waves-light">Import</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Script for store --}}
@push('scripts')
    <script>
        $('body').on('click', '#btn-importPerdin', function() {
            $('#modal-importPerdin').modal('show');

        });

        $('#formImport').on('submit', function() {
            // Change button simpan disabled
            $('#btn-saveImport').attr('disabled', 'disabled');
                $('#btn-saveImport').html(`
                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            Loading...
                `);
            // End


        });
    </script>
@endpush
