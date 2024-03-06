@push('styles')
    <link href="{{ asset('') }}public/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
@endpush
<div class="modal fade show" id="modal-comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="mdi mdi-comment-multiple-outline"></i> Komentar Pokok Pembicaraan</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @if($userPerdin != Auth::user()->id)
                <form id="formComment">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-12 mb-1">
                                <label for="comment">Komentar</label>
                                <input type="hidden" name="" id="id-comment">
                                <input type="hidden" name="" id="rule-comment">
                                <textarea name="comment" id="comment" type="date" class="form-control" placeholder="Masukan komentar"></textarea>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-commentar"></div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-sm btn-info " id="btn-sendComment" style="float: right">Kirim Komentar</button>
                        </div>
                    </div>
                </form>
                @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-4" id="comment-box">

                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect waves-light"
                    data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Show modal
        $(document).ready(function() {
        const perdinId = @json($dataId);
            // Function to fetch and display comments
        function fetchComments(globalId,rule) {
            $.ajax({
                url: `{{url('/inspector/get/comment')}}/${globalId}?rule=${rule}&perdin_id=${perdinId}`,
                method: 'GET',
                success: function(response) {
                    let dataComment = "";
                    response.data.forEach(function(comment) {
                        dataComment += `
                            <div class="media mb-3 w-100">
                                <img class="d-flex mr-3 rounded-circle" src="{{asset('')}}public/assets/images/users/avatar-8.jpg" alt="Generic placeholder image" height="48">
                                <div class="media-body">
                                    <h6 class="mt-0">${comment.user.name}</h6>
                                    ${comment.comment}
                                </div>
                            </div>
                        `;
                    });

                    $('#comment-box').html(dataComment);
                },
                error: function(error) {
                    // Handle error
                }
            });
        }

        // Event listener for clicking the comment button
        $('body').on('click', '#btn-comment', function() {
            const globalId = $(this).data('id');
            const rule = $(this).data('rule');
            $('#id-comment').val(globalId);
            $('#rule-comment').val(rule);
            $('#modal-comment').modal('show');
            fetchComments(globalId, rule); // Fetch and display comments when the modal is opened
        });

        // Event listener for submitting a comment
        $('#btn-sendComment').on('click', function(e) {
            e.preventDefault();
            const globalId = $('#id-comment').val();
            const rule = $('#rule-comment').val();
            console.log(globalId, rule);
            let comment = $('#comment').val();
            $.ajax({
                url: `{{route('postComment')}}`,
                method: 'POST',
                data: {'comment': comment, 'comment_id': globalId, 'rule': rule, perdin_id:perdinId},
                success: function(response) {
                    fetchComments(globalId, rule); // Refresh comments after successfully posting a comment
                    $('#comment').val('');
                },
                error: function(error) {
                    // Handle error
                }
            });
        });



    })
        // Store to controller

    </script>
@endpush
