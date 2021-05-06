@extends('layouts.master')

@section('title', 'Login - ')

@section('master')
    <div class="row h-100 w-100 align-items-center bg-light g-0">
        <div class="col">

            <div class="mx-auto bg-white p-4 rounded-3 shadow-sm" style="width: 90%; max-width: 400px;">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i style="font-size: 3rem;" class="bi bi-shield-lock"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fs-4 lh-sm fw-bold">{{ config('app.name') }}</div>
                        <div class="lh-sm">ADMINISTRATOR</div>
                    </div>
                </div>

                <form id="form" method="post" action="">
                    <div class="mb-2">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" name="remember" type="checkbox" value="" id="remember">
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div>
                            <button type="submit" id="button" class="btn btn-primary">Login <i class="bi bi-box-arrow-in-right"></i></button>
                        </div>
                    </div>
    
                </form>
            </div>

        </div>
    </div>
@endsection

@push('js')
<script>
    const form = document.getElementById('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const url = this.getAttribute('action');
        const form_data = new FormData(this);
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const button = document.getElementById('button');
        const buttonDefaultHTML = button.innerHTML;
        button.setAttribute("disabled", "disabled");
        button.innerHTML = 'Loading..';

        axios({
            method: "post",
            url: url,
            data: form_data,
            headers: {
                "Content-Type": "multipart/form-data",
                "Accept": "application/json",
                "X-CSRF-TOKEN": csrf
            },
        })
        .then((response) => {
            window.location.href = response.data.redirect;
        })
        .catch((error) => {
            const data = error.response.data;

            if (typeof data.code != "undefined") {
                if(data.code == 'input'){
                    alert('Please complete the form correctly.');
                } else if(data.code == 'user-not-found'){
                    alert('Email or password you entered is not valid.');
                } else {
                    alert('Something went wrong, please try again later.');
                }
            } else {
                alert('Something went wrong, please try again later.');
            }
            
            button.innerHTML = buttonDefaultHTML;
            button.removeAttribute("disabled");
        });
    });
</script>
@endpush