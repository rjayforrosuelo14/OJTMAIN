@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Intern</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('intern.update', $intern->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $intern->first_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $intern->last_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Course</label>
                        <input type="text" name="course" class="form-control" value="{{ old('course', $intern->course) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Section</label>
                        <input type="text" name="section" class="form-control" value="{{ old('section', $intern->section) }}" required>
                    </div>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('intern.show', $intern->id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
