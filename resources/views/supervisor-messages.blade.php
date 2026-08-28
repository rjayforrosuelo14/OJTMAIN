@extends('layouts.supervisor')

@section('content')
<div class="container-fluid mt-4 mb-5" style="max-width: 1200px;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0" style="color: #667eea; font-weight: 700;">
                        <i class="fas fa-comments mr-2"></i>Messages
                    </h2>
                    <p class="text-muted small mt-2">
                        <i class="fas fa-info-circle"></i> Total connected interns: {{ $interns->count() }}
                    </p>
                </div>
                <a href="{{ route('supervisor.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Messages Section -->
    <div class="row">
        @if($interns->count() > 0)
            @foreach($interns as $intern)
                <div class="col-md-6 col-lg-4 mb-3">
                    <a href="{{ route('supervisor.messages.conversation', $intern->id) }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 h-100 transition" style="cursor: pointer; transition: all 0.3s ease;">
                            <!-- Header with gradient -->
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1">{{ $intern->first_name }} {{ $intern->last_name }}</h5>
                                        <small class="opacity-75">{{ $intern->email }}</small>
                                    </div>
                                    @if($intern->unread_count > 0)
                                        <span class="badge badge-danger ml-2">{{ $intern->unread_count }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Body with info -->
                            <div class="card-body">
                                <!-- Hours Progress -->
                                @php
                                    $hours = \App\Models\TimeLog::where('intern_id', $intern->id)
                                        ->sum(\DB::raw('TIMESTAMPDIFF(SECOND, time_in, time_out) / 3600'));
                                    $hoursFormatted = number_format($hours, 1);
                                    $progress = min(($hours / 486) * 100, 100);
                                @endphp
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> Hours Tracked
                                        </small>
                                        <small class="font-weight-bold" style="color: #667eea;">
                                            {{ $hoursFormatted }}/486h
                                        </small>
                                    </div>
                                    <div class="progress" style="height: 8px; border-radius: 10px; background-color: #e9ecef;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $progress }}%; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); border-radius: 10px;"
                                             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                @if($hours >= 486)
                                    <div class="alert alert-success py-2 px-3 mb-0" style="border-radius: 8px; border: none;">
                                        <small>
                                            <i class="fas fa-check-circle"></i> OJT Complete
                                        </small>
                                    </div>
                                @else
                                    <small class="text-muted">
                                        <i class="fas fa-hourglass-half"></i> {{ number_format(486 - $hours, 1) }}h remaining
                                    </small>
                                @endif
                            </div>

                            <!-- Footer with arrow hint -->
                            <div class="card-footer border-0" style="background: #f8f9fa;">
                                <small class="text-muted">
                                    <i class="fas fa-envelope"></i> Click to view messages
                                    <i class="fas fa-arrow-right float-right" style="color: #667eea;"></i>
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 3rem; color: #d1d5db; margin-bottom: 20px;">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h5 style="color: #667eea;">No Connected Interns</h5>
                        <p class="text-muted mb-3">
                            You don't have any connected interns yet. Start by selecting interns from your dashboard.
                        </p>
                        <a href="{{ route('supervisor.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .transition:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(102, 126, 234, 0.15) !important;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem;
    }

    .progress {
        background-color: #e9ecef !important;
    }

    @media (max-width: 768px) {
        h2 {
            font-size: 1.5rem;
        }

        .col-md-6 {
            margin-bottom: 1.5rem;
        }
    }
</style>
@endsection
