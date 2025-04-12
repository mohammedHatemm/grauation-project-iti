
@extends('layouts.employee')

@section('content')
<div class="container">
    <h1 class="mb-4">Assign a Delegate to the Order#{{ $order->id }}</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Choose a Delegate from the List</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Delegate_name/th>
                        <th>city</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($delegates as $delegate)
                    <tr>
                        <td>{{ $delegate->name }}</td>

                        <td>{{ $delegate->address ?? 'Unknown' }}</td>
                        <td>{{ $delegate->phone }}</td>
                        <td>
                            <button class="btn btn-primary choose-delegate"
                                    data-delegate-id="{{ $delegate->id }}"
                                    data-delegate-name="{{ $delegate->name }}"
                                    data-delegate-region="{{ $delegate->regions ?? 'Unknown' }}"
                                    data-delegate-phone="{{ $delegate->phone }}">
                                Choose
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('employee.orders.pending') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
