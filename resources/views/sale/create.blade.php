@extends('layouts.app')

@section('title', 'Sale / Create - ')

@section('content-max-width', '500px')

@section('content')

    <div class="mb-4">
        <a href="{{ route('car.index') }}" class="d-block mb-4">
            <i class="bi bi-arrow-left"></i> Go Back
        </a>

        <h3>Create New Sale</h3>
    </div>

    <form method="get" action="">

        <div class="mb-3">
            <label class="form-label" for="name">Please enter customer email first</label>
            <input type="email" name="email" value="{{ $email }}" class="form-control" {{ $email != null ? "disabled" : "" }} required />
        </div>

        @if($email != null)
            <a href="{{ route('sale.create') }}">Reset Email</a>
        @else
            <button type="submit" class="btn btn-primary" id="button">
                Check <i class="bi bi-arrow-right ms-2"></i>
            </button>
        @endif

    </form>

    @if($email != null)

        <form id="form" method="post" action="">

            <h5 class="mt-5">Customer Data</h5>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="customer_name" class="form-control" value="{{ $customer != null ? $customer->name : '' }}" required />
                <input type="hidden" name="customer_email" value="{{ $email }}" />
            </div>
            <div class="mb-5">
                <label class="form-label">Phone</label>
                <input type="text" name="customer_phone" class="form-control form-phone" value="{{ $customer != null ? $customer->phone : '' }}" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="text" name="date" class="form-control form-date" value="{{ date('d/m/Y') }}" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Choose Car</label>
                <select class="form-select" name="car_id" id="car-id" required>
                    <option value="">-</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" data-price="{{ $car->price }}">{{ $car->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5">
                <label class="form-label" for="car_price">Price</label>
                <input type="text" name="car_price" id="car-price" class="form-control" readonly required />
                <small>
                    <a href="#" id="change-price"><i class="bi bi-pencil-square me-1"></i> Change Price</a>
                </small>
            </div>

            <button type="submit" class="btn btn-primary" id="button">
                <i class="bi bi-save me-2"></i> Save
            </button>

        </form>

        @push('js')
        <script>
            document.getElementById('car-id').addEventListener('change', function(e) {
                var price =  this.options[this.selectedIndex].getAttribute('data-price');
                var price_elem = document.getElementById('car-price');
                price_elem.value = price;
                setFormNumber(price_elem);
            });

            document.getElementById('change-price').addEventListener('click', function(e){
                e.preventDefault();
                document.getElementById('car-price').removeAttribute('readonly');
                document.getElementById('car-price').focus();
                document.getElementById('car-price').select();
                this.style.display = 'none';
            });

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
                            alert(data.message);
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

    @endif
    
@endsection