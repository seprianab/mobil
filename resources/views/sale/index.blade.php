@extends('layouts.app')

@section('title', 'Sale - ')

@section('content')
    
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h3>Sale</h3>
        <div>
            <a href="{{ route('sale.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Create New
            </a>
        </div>
    </div>

    <form method="get" action="">
        <div class="table-tool mb-3">
            <div class="flex-grow-1">
                <label class="form-label" for="search">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ $search }}" />
                </div>
            </div>
            <div class="d-flex align-items-center">
                <button type="submit" class="btn btn-outline-primary w-100">
                    Search
                </button>
                @if($is_filtered)
                    <a class="ms-3" href="{{ route('sale.index') }}">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <div class="table-special">
        <table class="table table-hover align-start">
            <thead>
                <tr>
                    <th class="col-fix">#</th>
                    <th class="col-fix"><div class="col-date">Date</div></th>
                    <th>Customer</th>
                    <th>Car</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="col-fix"><div class="col-action action-1">&nbsp;</div></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $row)
                <tr {!! $row->status == 2 ? 'class="row-disabled"' : '' !!}>
                    <td>{{ ++$number }}</td>
                    <td>{{ toDate($row->date) }}</td>
                    <td>
                        <div>{{ $row->customer_name }}</div>
                        <small class="text-muted">
                            {{ $row->customer_phone }} | {{ $row->customer_email }}
                        </small>
                    </td>
                    <td>{{ $row->car_name }}</td>
                    <td>{{ toNumber($row->car_price) }}</td>
                    <td>{{ $row->status_text }}</td>
                    <td>
                        @if($row->status == 1)
                        <div class="table-action">
                            <form method="post" action="{{ route('sale.cancel', ['id' => $row->id]) }}" class="form-cancel">
                                @method('put')
                                <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-circle"></i> Cancel</button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="mt-4">
        {{ $data->links() }}
    </div>
    
@endsection

@push('js')
<script>

    document.querySelectorAll('.form-cancel').forEach(form_delete => 
        form_delete.addEventListener('submit', function (e) {
            e.preventDefault();
            
            var confirmed = confirm('Are you sure?');

            if(!confirmed){
                return false;
            } else {
                const url = this.getAttribute('action');
                const form_data = new FormData(this);
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const button = this.querySelector('button');
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
                    window.location.href = '';
                })
                .catch((error) => {
                    alert('Something went wrong, please try again later.');
                    
                    button.innerHTML = buttonDefaultHTML;
                    button.removeAttribute("disabled");
                });
            }
        })
    );

</script>
@endpush