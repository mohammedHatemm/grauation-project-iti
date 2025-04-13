@extends('layouts.employee')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Add New Delegate</h1>
    <div class="card p-4">
        <form action="{{ route('employee.orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="region_id">Region</label>
                <select name="region_id" class="form-control" required>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Add Delivery</button>
        </form>
    </div>
</div>
<a href="{{ route('employee.orders.pending') }}" class="btn btn-secondary">Back</a>
@endsection
