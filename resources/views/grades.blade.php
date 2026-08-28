@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #dc2626;
            --primary-dark: #991b1b;
            --secondary: #475569;
            --success: #dc2626;
            --warning: #f59e0b;
            --danger: #dc2626;
            --dark: #111827;
            --light: #f8fafc;
            --border: #e2e8f0;
            --purple: #dc2626;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f8fafc; margin: 0; padding: 0; color: var(--dark); }

        .grades-container { max-width: 1400px; margin: 0 auto; background: white; border-radius: 16px; padding: 32px; box-shadow: var(--shadow-lg); }

        .page-header {
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark);
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header p {
            color: var(--secondary);
            font-size: 14px;
            margin: 0;
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert.success {
            background: rgba(220, 38, 38, 0.12);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert.error {
            background: rgba(220, 38, 38, 0.12);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* Filter Section */
        .filter-section {
            background: var(--light);
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid transparent;
            background: white;
            color: var(--dark);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .filter-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary-dark);
        }

        .badge {
            background: var(--danger);
            color: white;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
        }

        /* Search Bar */
        .search-container {
            flex: 1;
            min-width: 250px;
            max-width: 400px;
            position: relative;
        }

        .search-wrapper {
            display: flex;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .search-wrapper:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
        }

        .search-input {
            flex: 1;
            padding: 12px 16px;
            border: none;
            font-size: 14px;
            outline: none;
            font-family: inherit;
        }

        .search-input::placeholder {
            color: var(--secondary);
        }

        .search-btn {
            padding: 12px 20px;
            border: none;
            background: var(--primary);
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .search-btn:hover {
            background: #b91c1c;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        th:first-child {
            border-radius: 0;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: var(--light);
            transform: scale(1.01);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 16px 20px;
            color: var(--dark);
            font-size: 14px;
        }

        td:first-child {
            font-weight: 600;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view {
            background: rgba(220, 38, 38, 0.08);
            color: var(--danger);
            border: 1px solid rgba(220, 38, 38, 0.3);
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-request {
            background: rgba(220, 38, 38, 0.08);
            color: var(--danger);
            border: 1px solid rgba(220, 38, 38, 0.3);
        }

        .btn-request:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .status-label {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-requested {
            background: rgba(220, 38, 38, 0.08);
            color: var(--danger);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--secondary);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Section Badge */
        .section-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            background: rgba(220, 38, 38, 0.1);
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .grades-container {
                padding: 20px;
            }

            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                max-width: 100%;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 12px 10px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        /* Loading Animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="grades-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
               
            </h1>
           
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-controls">
                {{-- Show All Button --}}
                <form method="GET" action="{{ route('grades') }}" style="display: inline;">
                    <input type="hidden" name="filter" value="all">
                    <button type="submit" class="filter-btn {{ !request('filter') || request('filter') === 'all' ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        Show All
                        @if(array_sum($sectionCounts))
                            <span class="badge">{{ array_sum($sectionCounts) }}</span>
                        @endif
                    </button>
                </form>

                {{-- Section Buttons --}}
                @foreach(array_keys($sectionCounts) as $section)
                    <form method="GET" action="{{ route('grades') }}" style="display: inline;">
                        <input type="hidden" name="filter" value="{{ $section }}">
                        <button type="submit" class="filter-btn {{ request('filter') === $section ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            {{ $section }}
                            @if(isset($sectionCounts[$section]) && $sectionCounts[$section] > 0)
                                <span class="badge">{{ $sectionCounts[$section] }}</span>
                            @endif
                        </button>
                    </form>
                @endforeach

                {{-- Search Bar --}}
                <div class="search-container">
                    <form class="search-wrapper" action="{{ route('grades') }}" method="GET">
                        <input 
                            type="text" 
                            name="search" 
                            class="search-input" 
                            placeholder="Search by name or section..." 
                            value="{{ request('search') }}" 
                            id="searchInput"
                        >
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
        @if($interns->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Full Name</th>
                            <th><i class="fas fa-layer-group"></i> Section</th>
                            <th><i class="fas fa-certificate"></i> Certificate</th>
                            <th><i class="fas fa-file-alt"></i> Evaluation Form</th>
                            <th><i class="fas fa-cog"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interns as $intern)
                            <tr>
                                <td>
                                    <strong>{{ $intern->first_name }} {{ $intern->last_name }}</strong>
                                </td>
                                <td>
                                    <span class="section-badge">{{ $intern->section }}</span>
                                </td>
                                @foreach(['certificate', 'evaluation'] as $type)
                                    <td>
                                        @php
                                            $hasSubmission = isset($submissions[$intern->id][$type]);
                                            $wasRequested = isset($requests[$intern->id][$type]);
                                        @endphp

                                        @if($hasSubmission && !empty($submissions[$intern->id][$type]->file_path))
                                            <a href="{{ asset('storage/' . $submissions[$intern->id][$type]->file_path) }}"
                                               class="btn btn-view" target="_blank">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        @elseif($wasRequested)
                                            <span class="status-label status-requested">
                                                <i class="fas fa-clock"></i>
                                                Requested
                                            </span>
                                        @else
                                            <form action="{{ route('grades.request') }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="intern_id" value="{{ $intern->id }}">
                                                <input type="hidden" name="type" value="{{ $type }}">
                                                <button type="submit" class="btn btn-request">
                                                    <i class="fas fa-paper-plane"></i>
                                                    Request
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endforeach
                                <td>
                                    <div class="action-buttons">
                                        <form action="{{ route('intern.destroy', $intern->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you absolutely sure you want to delete {{ $intern->first_name }} {{ $intern->last_name }}? This will permanently delete the intern and ALL their data including time logs, journals, grades, messages, and documents. This action cannot be undone!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">
                                                <i class="fas fa-trash-alt"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Interns Found</h3>
                <p>
                    @if(request('search'))
                        No results found for "{{ request('search') }}"
                    @elseif(request('filter') && request('filter') !== 'all')
                        No accepted interns for section {{ request('filter') }}
                    @else
                        No accepted interns available at the moment
                    @endif
                </p>
            </div>
        @endif
    </div>

    <script>
        // Real-time search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('tbody tr');
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    
                    tableRows.forEach(row => {
                        const nameCell = row.querySelector('td:first-child');
                        const sectionCell = row.querySelector('td:nth-child(2)');
                        
                        if (nameCell && sectionCell) {
                            const name = nameCell.textContent.toLowerCase();
                            const section = sectionCell.textContent.toLowerCase();
                            
                            if (name.includes(searchTerm) || section.includes(searchTerm)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });

                    // Show/hide empty state
                    const visibleRows = Array.from(tableRows).filter(row => row.style.display !== 'none');
                    if (visibleRows.length === 0 && searchTerm) {
                        showEmptyState();
                    } else {
                        hideEmptyState();
                    }
                });
            }

            // Add smooth scroll to top on filter change
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            function showEmptyState() {
                const tableContainer = document.querySelector('.table-container');
                if (tableContainer && !document.querySelector('.search-empty-state')) {
                    const emptyState = document.createElement('div');
                    emptyState.className = 'empty-state search-empty-state';
                    emptyState.innerHTML = `
                        <i class="fas fa-search"></i>
                        <h3>No Results Found</h3>
                        <p>Try adjusting your search terms</p>
                    `;
                    tableContainer.style.display = 'none';
                    tableContainer.parentElement.appendChild(emptyState);
                }
            }

            function hideEmptyState() {
                const emptyState = document.querySelector('.search-empty-state');
                const tableContainer = document.querySelector('.table-container');
                if (emptyState) {
                    emptyState.remove();
                }
                if (tableContainer) {
                    tableContainer.style.display = 'block';
                }
            }
        });
    </script>
@endsection