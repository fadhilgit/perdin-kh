@push('styles')
    <link href="{{ asset('') }}public/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
@endpush
<div class="modal fade show" id="modal-editPerdin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bx bx-user-plus"></i> Edit Perdin</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditPerdin">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="start_date">Tanggal</label>
                                <input name="start_date" id="start_date" type="date" class="form-control">
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-start_date"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end_date">&nbsp;</label>
                                <input name="end_date" id="end_date" type="date" class="form-control">
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-end_date"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="start_time">Waktu</label>
                                <input name="start_time" id="start_time" type="time" class="form-control">
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-start_time"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end_time">&nbsp;</label>
                                <input name="end_time" id="end_time" type="time" class="form-control">
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-end_time"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="no_voucher">Nomer Voucher</label>
                                <input name="no_voucher" id="no_voucher" type="text" class="form-control" placeholder="Masukan Nomer Voucher..."></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_voucher"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="place">Tempat</label>
                                <textarea name="place" id="place" class="form-control" placeholder="Masukan tempat..."></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-place"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="project">Proyek</label>
                                <textarea name="project" id="project" class="form-control" placeholder="Masukan proyek..."></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-project"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="agenda">Agenda Perjalanan Dinas</label>
                                <textarea name="agenda" id="agenda" class="form-control" placeholder="Masukan Agenda Perjalanan Dinas..."></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-agenda"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="personel_kwarsa">Personel Kwarsa Yang Hadir</label>
                                <textarea name="personel_kwarsa" id="personel_kwarsa" class="form-control" placeholder="Masukan Personel Kwarsa..."></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-personel_kwarsa"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="personel_other">Personel Lain Yang Hadir</label>
                                <textarea name="personel_other" id="personel_other" class="form-control" placeholder="Masukan Personel Kwarsa..."></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-personel_other"></div>
                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light"
                    data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                    id="btn-updatePerdin">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Show modal
        $(document).ready(function() {
            const globalId = $('#btn-editPerdin').data('id');

            $('body').on('click', '#btn-editPerdin', function() {
                const id = $(this).data('id');
                $.ajax({
                    url:`{{url('/dashboard/detail')}}/${id}`,
                    method: 'GET',
                    success: function(response) {
                        $('#start_date').val(response.data[0].start_date);
                        $('#end_date').val(response.data[0].end_date);
                        $('#start_time').val(response.data[0].start_time);
                        $('#end_time').val(response.data[0].end_time);
                        $('#no_voucher').val(response.data[0].no_voucher);
                        $('#place').val(response.data[0].place);
                        $('#project').val(response.data[0].project);
                        $('#agenda').val(response.data[0].agenda);
                        $('#personel_kwarsa').val(response.data[0].personel_kwarsa);
                        $('#personel_other').val(response.data[0].personel_other);
                    }
                })


                $('#modal-editPerdin').modal('show');
            });

            $('#formEditPerdin').on('submit', function(event) {
                event.preventDefault();
                $('#btn-updatePerdin').attr('disabled', 'disabled');
                $('#btn-updatePerdin').html(`
                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            Loading...
                `);
                let formUpdatePerdin = $(this).serialize();
                console.log(globalId);
                $.ajax({
                    url:`{{url('/dashboard/detail/update')}}/${globalId}`,
                    method:'PUT',
                    data: formUpdatePerdin,
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

                    }, error: function(error) {
                        $('#btn-updatePerdin').removeAttr('disabled');
                        $('#btn-updatePerdin').html(`
                            Update
                        `);
                        if(error.responseJSON.start_date) {
                            $('#alert-start_date').removeClass('d-none');
                            $('#alert-start_date').addClass('d-block');

                            $('#alert-start_date').html(error.responseJSON.start_date[0]);
                        }
                        if(error.responseJSON.end_date) {
                            $('#alert-end_date').removeClass('d-none');
                            $('#alert-end_date').addClass('d-block');

                            $('#alert-end_date').html(error.responseJSON.end_date[0]);
                        }
                        if(error.responseJSON.start_time) {
                            $('#alert-start_time').removeClass('d-none');
                            $('#alert-start_time').addClass('d-block');

                            $('#alert-start_time').html(error.responseJSON.start_time[0]);
                        }
                        if(error.responseJSON.end_time) {
                            $('#alert-end_time').removeClass('d-none');
                            $('#alert-end_time').addClass('d-block');

                            $('#alert-end_time').html(error.responseJSON.end_time[0]);
                        }
                        if(error.responseJSON.end_time) {
                            $('#alert-end_time').removeClass('d-none');
                            $('#alert-end_time').addClass('d-block');

                            $('#alert-end_time').html(error.responseJSON.end_time[0]);
                        }
                        if(error.responseJSON.place) {
                            $('#alert-place').removeClass('d-none');
                            $('#alert-place').addClass('d-block');

                            $('#alert-place').html(error.responseJSON.place[0]);
                        }
                        if(error.responseJSON.agenda) {
                            $('#alert-agenda').removeClass('d-none');
                            $('#alert-agenda').addClass('d-block');

                            $('#alert-agenda').html(error.responseJSON.agenda[0]);
                        }
                        if(error.responseJSON.project) {
                            $('#alert-project').removeClass('d-none');
                            $('#alert-project').addClass('d-block');

                            $('#alert-project').html(error.responseJSON.project[0]);
                        }
                        if(error.responseJSON.personel_kwarsa) {
                            $('#alert-personel_kwarsa').removeClass('d-none');
                            $('#alert-personel_kwarsa').addClass('d-block');

                            $('#alert-personel_kwarsa').html(error.responseJSON.personel_kwarsa[0]);
                        }

                    }
                })

            })
        })
        // Store to controller

    </script>
@endpush
