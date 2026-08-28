@extends('layouts.intern')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">

   

    <!-- Header -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 0; color: white; margin-bottom: 40px; border-radius: 12px;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-clock animated-icon" aria-hidden="true"></i>
                Daily Time Record (DTR)
            </h1>
            <p style="font-size: 16px; opacity: 0.9;">Track your working hours and monitor your monthly progress</p>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <!-- Monthly Hours -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #667eea;">
            <h3 style="font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 10px;">📅 This Month</h3>
            <p style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">{{ $intern->getTotalMonthlyHours() ?? 0 }}h</p>
            <p style="font-size: 12px; color: #666; margin-top: 5px;">Target: 160 hours</p>
        </div>

        <!-- Total Hours -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #0891b2;">
            <h3 style="font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 10px;">⏳ Total Hours</h3>
            <p style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">{{ $totalHours ?? 0 }}h</p>
            <p style="font-size: 12px; color: #666; margin-top: 5px;">Required: 486 hours</p>
        </div>

        <!-- Today's Status -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #059669;">
            <h3 style="font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 10px;">📊 Today Status</h3>
            @php
                $today = \Carbon\Carbon::today();
                $todayLog = $logs->where('date', $today->format('Y-m-d'))->first();
            @endphp
            <p style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">
                {{ $todayLog ? ($todayLog->time_out ? 'Completed' : 'In Progress') : 'Not Started' }}
            </p>
            <p style="font-size: 12px; color: #666; margin-top: 5px;">
                @if($todayLog)
                    {{ $todayLog->time_in ?? '--:--' }} - {{ $todayLog->time_out ?? '--:--' }}
                @else
                    No entry
                @endif
            </p>
        </div>

        <!-- Progress -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f59e0b;">
            <h3 style="font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 10px;">🎯 Progress</h3>
            <p style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">{{ round(($totalHours / 486) * 100, 1) }}%</p>
            <p style="font-size: 12px; color: #666; margin-top: 5px;">Of OJT completion</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 40px;">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Overall OJT Progress</h3>
        <div style="background: #e5e7eb; height: 30px; border-radius: 15px; overflow: hidden; margin-bottom: 15px;">
            <div style="background: linear-gradient(90deg, #667eea 0%, #764ba2 100%); height: 100%; width: {{ round(($totalHours / 486) * 100, 1) }}%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                {{ round(($totalHours / 486) * 100, 1) }}%
            </div>
        </div>
        <p style="font-size: 13px; color: #666;">You've completed <strong>{{ $totalHours ?? 0 }} hours</strong> out of <strong>486 hours</strong> required for successful completion.</p>
    </div>

    <!-- Time In/Out Actions -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
        <form method="POST" action="{{ route('intern.timein') }}">
            @csrf
            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 20px; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <i style="margin-right: 10px;">➡️</i> Time In
            </button>
        </form>

        <form method="POST" action="{{ route('intern.timeout') }}">
            @csrf
            <button type="submit" style="width: 100%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 20px; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <i style="margin-right: 10px;">⬅️</i> Time Out
            </button>
        </form>
    </div>

    <!-- DTR Table -->
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 25px; border-bottom: 1px solid #e5e7eb;">
            <h2 style="font-size: 20px; font-weight: 600; margin: 0;">📋 DTR History</h2>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1f2937; font-size: 14px;">Date</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1f2937; font-size: 14px;">Day</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1f2937; font-size: 14px;">Time In</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1f2937; font-size: 14px;">Time Out</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1f2937; font-size: 14px;">Hours</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: #1f2937; font-size: 14px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        @php
                            $date = \Carbon\Carbon::parse($log->date);
                            $dayName = $date->format('l');
                            $in = $log->time_in ? \Carbon\Carbon::parse($log->date . ' ' . $log->time_in, 'Asia/Manila') : null;
                            $out = $log->time_out ? \Carbon\Carbon::parse($log->date . ' ' . $log->time_out, 'Asia/Manila') : null;
                            
                            if ($in && !$out) {
                                $out = \Carbon\Carbon::parse($log->date . ' 17:00:00', 'Asia/Manila');
                            }
                            
                            $hours = ($in && $out) ? round($in->diffInSeconds($out) / 3600, 2) : 0;
                            $status = $log->time_out ? 'Completed' : ($log->time_in ? 'In Progress' : 'Pending');
                            $statusColor = $log->time_out ? '#059669' : ($log->time_in ? '#f59e0b' : '#6b7280');
                        @endphp
                        <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.3s ease;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                            <td style="padding: 16px; color: #1f2937; font-weight: 500;">{{ $date->format('M d, Y') }}</td>
                            <td style="padding: 16px; color: #6b7280;">{{ $dayName }}</td>
                            <td style="padding: 16px; color: #1f2937; font-weight: 500;">{{ $log->time_in ?? '--:--' }}</td>
                            <td style="padding: 16px; color: #1f2937; font-weight: 500;">{{ $log->time_out ?? '--:--' }}</td>
                            <td style="padding: 16px; color: #1f2937; font-weight: 600;">{{ $hours }}h</td>
                            <td style="padding: 16px;">
                                <span style="display: inline-block; padding: 6px 12px; background: {{ $statusColor }}; color: white; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">
                                <p style="margin: 0; font-size: 14px;">No time logs yet. Start by clicking the Time In button above.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back to Dashboard Button -->
    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ route('intern.dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 14px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <i style="font-size: 16px;">🏠</i> Back to Dashboard
        </a>
    </div>

</div>

<style>
    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    .animated-icon {
        display: inline-block;
        animation: clock-bounce 1.6s ease-in-out infinite;
        transform-origin: center center;
    }

    @keyframes clock-bounce {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        25% {
            transform: translateY(-3px) rotate(-6deg);
        }
        50% {
            transform: translateY(-6px) rotate(0deg);
        }
        75% {
            transform: translateY(-3px) rotate(6deg);
        }
    }

    a:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }

    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }

        table {
            font-size: 12px !important;
        }

        th, td {
            padding: 10px !important;
        }
    }
</style>
@endsection
