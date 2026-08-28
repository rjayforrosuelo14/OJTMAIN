@extends('layouts.intern')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 12px; margin-bottom: 40px; color: white;">
        <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 10px;">
            <i class="fas fa-user-tie"></i> Select Your Supervisor
        </h1>
        <p style="font-size: 16px; opacity: 0.9; margin: 0;">Connect with a supervisor to manage your attendance and receive feedback</p>
    </div>

    <!-- Current Selection -->
    @if($intern->supervisor_id)
        <div style="background: #d1fae5; border-left: 4px solid #059669; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <h3 style="color: #047857; margin-top: 0;">✓ Currently Connected</h3>
            @php
                $currentSupervisor = \App\Models\Supervisor::find($intern->supervisor_id);
            @endphp
            <p style="margin: 10px 0 0 0; color: #065f46;">
                <strong>{{ $currentSupervisor->name ?? 'Unknown' }}</strong><br>
                <small>{{ $currentSupervisor->email ?? 'N/A' }}</small>
            </p>
        </div>
    @else
        <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <h3 style="color: #92400e; margin-top: 0;">⚠ No Supervisor Connected</h3>
            <p style="margin: 10px 0 0 0; color: #b45309;">Please select a supervisor below to get started.</p>
        </div>
    @endif

    <!-- Success Message -->
    @if(session('success'))
        <div style="background: #d1fae5; border-left: 4px solid #059669; padding: 15px; border-radius: 8px; margin-bottom: 30px; color: #047857;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Supervisors List -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; color: #1f2937;">
            <i class="fas fa-users"></i> Available Supervisors
        </h2>

        @if($supervisors->isEmpty())
            <div style="text-align: center; padding: 40px 20px; color: #6b7280;">
                <i style="font-size: 48px; opacity: 0.5; display: block; margin-bottom: 15px;">👤</i>
                <p style="font-size: 16px; font-weight: 500;">No supervisors available</p>
                <p style="font-size: 14px;">Please wait while supervisors are being set up.</p>
            </div>
        @else
            <div style="display: grid; gap: 20px;">
                @foreach($supervisors as $supervisor)
                    <div style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 20px; transition: all 0.3s ease; cursor: pointer;" 
                         onmouseover="this.style.borderColor='#667eea'; this.style.backgroundColor='#f9fafb';" 
                         onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='white';">
                        
                        <form method="POST" action="{{ route('intern.update-supervisor') }}" style="display: flex; justify-content: space-between; align-items: center;">
                            @csrf
                            <input type="hidden" name="supervisor_id" value="{{ $supervisor->id }}">
                            
                            <div>
                                <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600; color: #1f2937;">
                                    {{ $supervisor->name }}
                                </h3>
                                <p style="margin: 0; color: #6b7280; font-size: 14px;">
                                    <i class="fas fa-envelope"></i> {{ $supervisor->email }}
                                </p>
                                @php
                                    $internCount = \App\Models\Intern::where('supervisor_id', $supervisor->id)
                                        ->where('status', 'accepted')
                                        ->count();
                                @endphp
                                <p style="margin: 8px 0 0 0; color: #667eea; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-users"></i> Managing {{ $internCount }} intern{{ $internCount !== 1 ? 's' : '' }}
                                </p>
                            </div>
                            
                            <div>
                                @if($intern->supervisor_id === $supervisor->id)
                                    <button type="button" style="background: #059669; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: default; opacity: 0.7;">
                                        <i class="fas fa-check"></i> Selected
                                    </button>
                                @else
                                    <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)';"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <i class="fas fa-link"></i> Connect
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Back to Dashboard -->
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('intern.dashboard') }}" style="display: inline-block; background: #e5e7eb; color: #1f2937; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"
           onmouseover="this.style.background='#d1d5db';"
           onmouseout="this.style.background='#e5e7eb';">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="display: grid; gap: 20px"] > div {
            flex-direction: column !important;
        }
        
        div[style*="display: flex; justify-content: space-between"] {
            flex-direction: column !important;
            gap: 15px;
        }
    }
</style>
@endsection