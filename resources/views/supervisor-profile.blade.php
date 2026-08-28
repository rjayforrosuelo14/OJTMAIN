@extends('layouts.supervisor')

@section('content')
<div style="max-width:720px; margin:40px auto;">
    <a href="{{ route('supervisor.dashboard') }}" style="display:inline-flex; align-items:center; gap:8px; margin-bottom:18px; padding:9px 14px; border:1px solid #007bff; border-radius:8px; color:#007bff; text-decoration:none; font-weight:600; font-size:13px;">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <h2>My Profile</h2>

    @if(session('success'))
        <div style="padding:12px; background:#ecfdf5; border:1px solid #10b981; color:#065f46; border-radius:8px; margin-bottom:12px;">{{ session('success') }}</div>
    @endif

    <div style="display:flex; gap:18px; align-items:center; margin-top:18px;">
        <div style="width:120px; height:120px; border-radius:14px; overflow:hidden; background:rgba(0,0,0,0.05); display:flex; align-items:center; justify-content:center;">
            @php
                $sup = Auth::guard('supervisor')->user();
                $img = null;
                if ($sup) {
                    $base = public_path('storage/supervisor profile/supervisor_' . $sup->id);
                    $exts = ['png','jpg','jpeg','gif','webp'];
                    foreach ($exts as $e) {
                        if (file_exists($base . '.' . $e)) {
                            $img = asset('storage/supervisor profile/supervisor_' . $sup->id . '.' . $e);
                            break;
                        }
                    }
                }
            @endphp

            @if ($img)
                <img src="{{ $img }}" alt="Profile" style="width:100%; height:100%; object-fit:cover;">
            @else
                <i class="fas fa-user-circle" style="font-size:64px; color:#6b7280;"></i>
            @endif
        </div>

        <div style="flex:1">
            <form method="POST" action="{{ route('supervisor.profile.avatar') }}" enctype="multipart/form-data">
                @csrf
                <label style="display:block; margin-bottom:8px; font-weight:600;">Upload profile image</label>
                <input type="file" name="avatar" accept="image/*" required>
                @error('avatar')<div style="color:#dc2626; margin-top:8px;">{{ $message }}</div>@enderror
                <div style="margin-top:12px">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
