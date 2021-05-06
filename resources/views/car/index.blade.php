@extends('layouts.app')

@section('title', 'Car - ')

@section('content-max-width', '900px')

@section('content')
    
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h3>Car</h3>
        <div>
            <a href="{{ route('car.create') }}" class="btn btn-primary">
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
                    <a class="ms-3" href="{{ route('car.index') }}">Reset</a>
                @endif
            </div>
        </div>
    </form>

    <div class="table-special">
        <table class="table table-hover align-start">
            <thead>
                <tr>
                    <th class="col-fix"><div class="col-number">#</div></th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th class="col-fix"><div class="col-action action-2">&nbsp;</div></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $row)
                <tr>
                    <td>{{ ++$number }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ toNumber($row->price) }}</td>
                    <td>{{ toNumber($row->stock) }}</td>
                    <td>
                        <div class="table-action">
                            <a href="{{ route('car.edit', ['id' => $row->id]) }}" title="Edit" class="btn btn-outline-secondary btn-sm me-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form method="post" action="{{ route('car.delete', ['id' => $row->id]) }}" class="form-delete">
                                <button type="submit" class="btn btn-outline-secondary btn-sm"><i class="bi bi-trash"></i> Delete</button>
                            </form>
                        </div>
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

    document.querySelectorAll('.form-delete').forEach(form_delete => 
        form_delete.addEventListener('submit', function (e) {
            e.preventDefault();
            
            var confirmed = confirm('Are you sure?');

            if(!confirmed){
                return false;
            } else {
                const url = this.getAttribute('action');
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const button = this.querySelector('button');
                const buttonDefaultHTML = button.innerHTML;
                button.setAttribute("disabled", "disabled");
                button.innerHTML = 'Loading..';

                axios({
                    method: "delete",
                    url: url,
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