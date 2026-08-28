@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
        <h2 style="margin:0;">Connect Intern(s) to Supervisor: {{ $supervisor->name }}</h2>
        <div style="display:inline-flex;">
            <input type="text" id="internSearchInput" placeholder="Search intern name or email..." style="padding:8px 12px;border:1px solid #ccc;border-radius:5px 0 0 5px;width:260px;">
            <button type="button" style="padding:8px 12px;border:none;background:#38c172;color:#fff;border-radius:0 5px 5px 0;font-weight:bold;">🔍</button>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.connect-interns.save', $supervisor->id) }}">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Current Supervisor</th>
                </tr>
            </thead>
            <tbody id="internTableBody">
                @foreach($interns as $intern)
                    <tr>
                        <td>
                            <input type="checkbox" name="intern_ids[]" value="{{ $intern->id }}" {{ $intern->supervisor_id == $supervisor->id ? 'checked' : '' }}>
                        </td>
                        <td>{{ $intern->first_name }} {{ $intern->last_name }}</td>
                        <td>{{ $intern->email }}</td>
                        <td>
                            @if($intern->supervisor)
                                {{ $intern->supervisor->name }}
                            @else
                                <span style="color:#888;">None</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Connect Selected Intern(s)</button>
    </form>
</div>

<script>
// Real-time filter for interns table
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('internSearchInput');
    const rows = document.querySelectorAll('#internTableBody tr');
    if (!input) return;
    input.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const email = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            row.style.display = (name.includes(q) || email.includes(q)) ? '' : 'none';
        });
    });
});
</script>
@endsection 