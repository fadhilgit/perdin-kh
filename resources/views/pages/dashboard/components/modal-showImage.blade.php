@push('styles')
    <link href="{{ asset('') }}public/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}public/assets/plugins/dropify/dropify.min.css" rel="stylesheet" type="text/css">
    <style>
        .show-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .show-img:hover {
            border: 2px solid black;
            animation-duration: 1s;
        }
        .card {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0);
            transition: background 0.5s ease;

        }
        .card:hover .overlay{
            display: block;
            background: rgba(0, 0, 0, .75);
        }
        .overlay-content {
            position: absolute;
            transition: opacity .35s ease;
            z-index: 1;
            opacity: 0;
        }
        .button {
            padding: 8px 20px;
            color: rgb(224, 224, 224);
            border: solid 2px white;
        }

        .button a:link {
            color: #fff;
        }

        .card:hover .overlay-content {
        opacity: 1;
        color: #fff;
        }
    </style>
@endpush
<div class="modal fade show" id="modal-showImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-modal="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-images"></i> List Gambar</h5>
                <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <table class="w-100">
                        @foreach ($dataPerdin as $data)
                            @foreach ($data->perdinSubjectDiscussions as $dataRelation)
                                @foreach ($dataRelation->perdinSubjectImages as $key => $image)
                                @if($key % 2 == 0)
                                    <tr>
                                @endif
                                    <td class="">
                                        <div class="card">
                                            <img class="show-img" src="{{asset('')}}public/perdin_image/{{$image->image_name}}" alt="">
                                            <div class="overlay"></div>
                                            <div class="overlay-content">
                                                <button class="btn button" id="btn-deleteImage" data-id={{$image->id}}>
                                                    Hapus
                                                </button>
                                                <button class="btn button ">
                                                    <a class="popup-link" href="{{asset('')}}public/perdin_image/{{$image->image_name}}">View</a>
                                                </button>
                                            </div>

                                        </div>

                                    </td>

                                @if($key % 2 != 0)
                                </tr>
                                @endif
                                @if($dataRelation->perdinSubjectImages->count() !== 0 && $loop->last)
                                <td colspan="3" class=""> </td>
                                </tr>
                                @endif
                                @endforeach

                            @endforeach
                        @endforeach
                    </table>



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
        $('body').on('click','#btn-showImage', function() {
            $('#modal-showImage').modal('show');
        })

        $('body').on('click','#btn-deleteImage', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: 'Ingin menghapus gambar ini ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url:`{{url('/dashboard/detail/delete/image')}}/${id}`,
                        method: 'DELETE',
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
                            });
                        }
                    })
                }
            })
        })
    </script>
@endpush
