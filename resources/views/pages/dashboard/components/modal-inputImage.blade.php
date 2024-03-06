@push('styles')
    <link href="{{ asset('') }}public/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}public/assets/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css">
@endpush
<div class="modal fade show" id="modal-inputImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bx bx-user-plus"></i> Input Gambar</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUpdateImage">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <input type="hidden" name="id"  id="id">
                                <input type="hidden" name="rule" id="rule">
                                <div class="input-group">
                                    <input name="image[]" id="image" type="file" class="form-control" >
                                    <div class="input-group-append">
                                        <button id="btn-addInputImage" class="btn btn-dark waves-effect waves-light" type="button">+ Add</button>
                                    </div>
                                </div>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-image"></div>
                                <div id="form-addInputImage">

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light"
                    data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                    id="btn-updateImage">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('') }}public/assets/plugins/dropify/dropify.min.js"></script>
    <script>

        // Show modal
        $(document).ready(function() {

            $('body').on('click', '#btn-addInputImage', function() {
                console.log('tes');
                let inputImage = `
                <div class="input-group mt-2">
                    <input name="image[]" id="image" type="file" class="form-control" >
                    <div class="input-group-append">
                        <button id="btn-removeInputImage" class="btn btn-danger waves-effect waves-light" type="button">- Remove</button>
                    </div>
                </div>
                `;
                $('#form-addInputImage').append(inputImage);
            })

            $('body').on('click', '#btn-removeInputImage', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove()
            })

            $('body').on('click', '#btn-inputImage' ,function() {
                const id = $(this).data('id');
                const rule = $(this).data('rule');
                $('#id').val(id);
                $('#rule').val(rule);
                $('#modal-inputImage').modal('show');
            });

            $('#formUpdateImage').submit(function(e) {
                e.preventDefault();

                $('#btn-updateImage').attr('disabled', 'disabled');
                $('#btn-updateImage').html(`
                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            Loading...
                `);
            // End
                const id = $('#id').val();
                var formInputImage= new FormData(this);

                $.ajax({
                    url:`{{url('/dashboard/detail/updateSubject/image')}}/${id}`,
                    method: 'POST',
                    data: formInputImage,
                    processData: false, // Don't process the data
                    contentType: false,
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
                    $('#btn-updateImage').removeAttr('disabled');
                    $('#btn-updateImage').html(`
                        Update
                    `);
                    if(error.responseJSON.image) {
                            // Show alert
                        $('#alert-image').removeClass('d-none');
                        $('#alert-image').addClass('d-block');

                        // Add message
                        $('#alert-image').html(error.responseJSON.image[0]);
                        };
                    }
                });
            })

        });
    </script>
@endpush
