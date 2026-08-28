@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Intern Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $intern->first_name }} {{ $intern->last_name }}</p>
                    <p><strong>Email:</strong> {{ $intern->email }}</p>
                    <p><strong>Course:</strong> {{ $intern->course }}</p>
                    <p><strong>Section:</strong> {{ $intern->section }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Phone:</strong> {{ $intern->phone }}</p>
                    <p><strong>Company:</strong> {{ $intern->company_name ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($intern->status) }}</p>
                    <p><strong>Current Phase:</strong> {{ ucfirst(str_replace('_', ' ', $intern->current_phase)) }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light d-flex gap-2">
            <a href="{{ route('intern.edit', $intern->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('interns') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
