@extends('layouts.app')

@section('content')
<style>
    .search-input { padding: 10px; border: 1px solid #ccc; border-radius: 5px 0 0 5px; width: 240px; }
    .search-button { padding: 10px 16px; border: none; background: #38c172; color: white; border-radius: 0 5px 5px 0; cursor: pointer; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    th { background: #3490dc; color: white; }
    .doc-link { color: #2563eb; text-decoration: underline; }
</style>

<div class="container" style="max-width: 1100px; margin: 30px auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom: 16px;">
        <h1 style="margin:0;">📦 Archive</h1>
        <a href="{{ route('documents') }}" class="button" style="background:#6b7280; text-decoration:none;">⬅ Back</a>
    </div>

    <form method="GET" action="{{ route('documents.archive') }}" class="search-form" style="display:inline-flex; margin-bottom: 16px;">
        <input type="text" name="search" class="search-input" placeholder="Search name or section..." value="{{ request('search') }}" id="searchInput">
        <button type="submit" class="search-button">🔍</button>
    </form>

    @if($archivedInterns->isEmpty())
        <p style="text-align:center; color:#6b7280;">No archived interns found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Archived At</th>
                    <th>Documents</th>
                </tr>
            </thead>
            <tbody>
                @foreach($archivedInterns as $intern)
                    <tr>
                        <td>{{ $intern->first_name }} {{ $intern->last_name }}</td>
                        <td>{{ $intern->section ?? 'N/A' }}</td>
                        <td>{{ optional($intern->archived_at)->format('Y-m-d H:i') }}</td>
                        <td>
                            @php
                                $links = [];
                                if ($intern->application_letter) $links[] = '<a class="doc-link" target="_blank" href="'.route('documents.view', ['filename' => basename($intern->application_letter)]).'">Application</a>';
                                if ($intern->parents_waiver) $links[] = '<a class="doc-link" target="_blank" href="'.route('documents.view', ['filename' => basename($intern->parents_waiver)]).'">Parent\'s Waiver</a>';
                                if ($intern->acceptance_letter) $links[] = '<a class="doc-link" target="_blank" href="'.route('documents.view', ['filename' => basename($intern->acceptance_letter)]).'">Acceptance</a>';
                            @endphp
                            {!! $links ? implode(' · ', $links) : '<span style="color:#9ca3af;">No files</span>' !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
// Real-time filtering (client-side) similar to grades
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('searchInput');
    const rows = document.querySelectorAll('tbody tr');
    if (!input) return;
    input.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(1)')?.textContent.toLowerCase() || '';
            const section = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            row.style.display = (name.includes(q) || section.includes(q)) ? '' : 'none';
        });
    });
});
</script>
@endsection




