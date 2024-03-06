@extends('layouts.auth')

@section('content')
<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center min-vh-100">
                    <div class="w-100 d-block my-5">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center mb-4 mt-3">
                                            <a href="#">
                                                <span style="color:#495057; font-size:24px; font-weight:bold; "><img src="public/assets/images/logo-kwarsa1.png" alt=""
                                                    height="26"> e-PERDIN</span>
                                            </a>
                                        </div>
                                        <form method="POST" class="p-2" action="{{ route('register') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Nama Lengkap</label>
                                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required="" placeholder="Masukan nama" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="unitkerja_id">Unit Kerja</label>
                                                <select type="text" class="form-control @error('unitkerja_id') is-invalid @enderror" name="unitkerja_id" id="unitkerja_id" required>
                                                    <option value="">Pilih unit kerja</option>
                                                    @foreach ($unitkerjas as $unitkerja)
                                                        <option value="{{$unitkerja->id}}">{{$unitkerja->name}}</option>
                                                    @endforeach
                                                </select>

                                                @error('unitkerja_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="unitkerja_id">Sub Unit Kerja</label>
                                                <select class="form-control @error('subunitkerja_id') is-invalid @enderror" name="subunitkerja_id" id="subunitkerja_id" disabled>
                                                    <option value="">Pilih Sub unit kerja</option>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="second_position">Jabatan</label>
                                                <select class="form-control" name="second_position" id="second_position" required>
                                                    <option value="">Pilih jabatan</option>
                                                    @foreach ($secondPositions as $position)
                                                    <option value="{{$position->id}}">{{$position->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="telegram_id">Telegram ID</label>
                                                <input class="form-control " type="text" placeholder="Masukan Telegram Id" name="telegram_id" id="telegram_id">
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"  required="" placeholder="Masukan email" required autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input class="form-control @error('password') is-invalid @enderror" type="password" required="" name="password" placeholder="Enter your password" required autocomplete="password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-grop">
                                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                                <input id="password-confirm" type="password" class="form-control" placeholder="Konfirmasi password" name="password_confirmation" required autocomplete="new-password">
                                            </div>

                                            <div class="mb-3 mt-3 text-center">
                                                <button class="btn btn-primary btn-block" type="submit"> Sign Up </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->

                                <div class="row mt-4">
                                    <div class="col-sm-12 text-center">
                                        <p class="text-white-50 mb-0">Already have an account? <a href="{{route('loginPage')}}" class="text-white-50 ml-1"><b>Sign In</b></a></p>
                                    </div>
                                </div>

                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- end .w-100 -->
                </div> <!-- end .d-flex -->
            </div> <!-- end col-->
        </div> <!-- end row -->
    </div>
    <!-- end container -->
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#unitkerja_id').on('change', function() {
                let unitkerjaId = $('#unitkerja_id').val();
                console.log(unitkerjaId);
                $.ajax({
                    url:`{{url('/getSubUk')}}/${unitkerjaId}`,
                    method:'GET',
                    success:function(response) {
                        if(response.data) {
                            $('#subunitkerja_id').removeAttr('disabled')
                        }
                        let selectedSubUk = `<option value="">Pilih Sub unit kerja</option>`
                        response.data.forEach(row => {
                            selectedSubUk += `<option value="${row.id}">${row.name}</option>`
                        });

                        $('#subunitkerja_id').html(selectedSubUk);
                    }
                })
            })
        })
    </script>
@endpush
@endsection
