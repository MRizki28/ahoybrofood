<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="key" content="{{ env('APP_KEY') }}">
    <title>SIMAK - LOGIN</title>
    @include('BE.Layouts.styles')
</head>

<body>
    <div class="d-flex justify-content-center align-items-center h-100 background-auth" style="min-height: 100vh">
        <div class="content-wrapper">
            <div class=" d-flex justify-content-center align-items-center"
                style="padding: 1.25rem 1.25rem; flex-grow: 1;">
                <form style="width: 20rem;" id="formLogin">
                    @csrf
                    <div class="card mb-0" style="border: -1px solid black !important;">
                        <div class="card-body background-login">
                            <div class="text-center  ">
                                <img src="{{ asset('assets/FE/img/logo2.webp') }}" alt="login" width="140"
                                    height="100%">
                                <h5 class="mb-0 mt-4 font-weight-bold">Masuk ke akun Anda</h5>
                            </div>
                            <div>
                                <div class="form-group form-show-validation">
                                    <input type="text" class="form-control" placeholder="Username" name="username">
                                </div>
                                <div class="form-group form-show-validation">
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>

                            </div>
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-outline-danger btn-block p-2">Login</button>
                            </div>
                            {{-- <div class="row">
                                <div class="col-sm-12 text-center">
                                    <img src="{{ asset('img/logo/footerlogo.png') }}" width="100%">
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

@include('BE.Layouts.scripts')

<script>
    $(document).ready(function() {
        var key = $('meta[name="key"]').attr('content');

        function validationLogin() {
            $('#formLogin').validate({
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                },
                messages: {
                    username: {
                        required: "Field ini wajib diisi"
                    },
                    password: {
                        required: "Field ini wajib diisi"
                    }
                },
                highlight: function(element) {
                    $(element).closest('.form-show-validation').removeClass('has-success').addClass(
                        'has-error');
                },

                success: function(element) {
                    $(element).closest('.form-show-validation').removeClass('has-error').addClass(
                        'has-success');
                }
            });
        }

        validationLogin();

        $('#formLogin').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let submitButton = $(this).find(':submit');

            submitButton.attr('disabled', true);

            $.ajax({
                type: "POST",
                url: "{{ url('v1/auth/login') }}",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response)
                    submitButton.attr('disabled', false);
                    console.log(response)
                    if (response.message == "Check your validation") {
                        warningAlert();
                    } else if (response.message == "Unauthorization") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Username atau password anda salah',
                            icon: 'warning',
                            timer: 5000,
                            showConfirmButton: true
                        });
                    } else if (response.code == 400) {
                        errorAlert();
                    } else {
                        Swal.fire({
                            title: 'Success',
                            text: 'Login Berhasil',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: true
                        }).then(() => {
                            window.location.href = '/cms/be/menu';
                        });

                    }
                }
            });
        });
    });
</script>

</html>
