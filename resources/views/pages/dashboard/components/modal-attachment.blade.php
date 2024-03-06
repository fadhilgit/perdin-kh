@push('styles')
    <link href="{{ asset('') }}public/assets/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css">
@endpush
<div class="modal fade show" id="modal-updateAttachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bx bx-user-plus"></i> Update Lmapiran</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUpdateAttachment">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="attachment">File Lampiran</label>
                                <input type="hidden" name="id"  id="id">
                                <input name="attachment" id="attachment" type="file" class="form-control dropify" >
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-attachment"></div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light"
                    data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                    id="btn-updateAttachment">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{asset('')}}public/assets/plugins/dropify/dropify.min.js"></script>
<script>

    $(document).ready(function() {
        $('.dropify').dropify();
        $('body').on('click', '#btn-attachment', function() {
            const id = $(this).data('id');
            $('#id').val(id);
            $('#modal-updateAttachment').modal('show');
        })

        $('#formUpdateAttachment').on('submit', function(e) {
            e.preventDefault();
            let id = $('#id').val();
            var formUpdateAttachment = new FormData(this);
            $.ajax({
                url:`{{url('/dashboard/detail/updateAttachment')}}/${id}`,
                method: 'POST',
                processData: false, // Don't process the data
                contentType: false,
                data: formUpdateAttachment,
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

                }
            })
        })
    })
</script>

@endpush
