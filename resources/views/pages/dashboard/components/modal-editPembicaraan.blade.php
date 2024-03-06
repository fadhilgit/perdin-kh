@push('styles')

@endpush
<div class="modal fade show" id="modal-editPokokPembicaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form id="formEditPembicaraan">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="subject_discussion">Pokok Pembicaraan</label>
                                <textarea name="edit_subject_discussion" id="edit_subject_discussion" type="date" class="form-control"></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-edit_subject_discussion"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="followup_plan">Rencana Tindak Lanjut</label>
                                <textarea name="edit_followup_plan" id="edit_followup_plan" type="date" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_executor">Personel yang melaksanakan</label>
                                <textarea name="edit_user_executor" id="edit_user_executor" type="date" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="completion_target">Target Penyelesaian</label>
                                <textarea name="edit_completion_target" id="edit_completion_target" type="date" class="form-control"></textarea>
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

            $('body').on('click', '#btn-edit', function() {
                const id = $(this).data('id');
                url:`{{url('/dashboard/detail')}}`,
                method:'GET',
                success: function(response) {
                    $('#edit_subject_discussion').val(response.data[0].subject_discussion);
                    $('#edit_followup_plan').val(response.data[0].followup_plan);
                    $('#edit_user_executor').val(response.data[0].user_executor);
                    $('#edit_completion_target').val(response.data[0].completion_target);
                }


                $('#modal-editPokokPembicaraan').modal('show');
            });

            $('#formEditPerdin').on('submit', function(event) {
                event.preventDefault();
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
                        if(error.responseJSON.start_date) {
                            $('#alert-start_date').removeClass('d-none');
                            $('#alert-start_date').addClass('d-block');

                            $('#alert-start_date').html(error.responseJSON.start_date[0]);
                        }

                    }
                })

            })
        })
        // Store to controller

    </script>
@endpush
