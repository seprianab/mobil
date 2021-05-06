@extends('layouts.app')

@section('title', 'Car / Edit - ')

@section('content-max-width', '500px')

@section('content')

    <div class="mb-4">
        <a href="{{ route('car.index') }}" class="d-block mb-4">
            <i class="bi bi-arrow-left"></i> Go Back
        </a>

        <h3>Edit Car</h3>
    </div>

    <form id="form" method="post" action="">
        @method('put')
        <input type="hidden" name="redirect" value="{{ session('car.index') }}" />

        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $data->name }}" required />
        </div>

        <div class="mb-3">
            <label class="form-label" for="price">Price</label>
            <input type="text" name="price" class="form-control form-number" value="{{ $data->price }}" required />
        </div>

        <div class="mb-5">
            <label class="form-label" for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $data->stock }}" required />
        </div>

        <button type="submit" class="btn btn-primary" id="button">
            <i class="bi bi-save me-2"></i> Update
        </button>

    </form>
    
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