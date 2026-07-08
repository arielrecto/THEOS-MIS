<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave History Report — {{ $employee->first_name }} {{ $employee->last_name }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
            background: #fff;
            padding: 1cm 1.2cm;
        }

        /* Header */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #00a89f;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .school-name {
            font-size: 18px;
            font-weight: 700;
            color: #00a89f;
        }

        .report-title {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }

        .report-meta {
            text-align: right;
            font-size: 10px;
            color: #6b7280;
            line-height: 1.6;
        }

        /* Employee Info */
        .employee-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #00a89f;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .employee-name {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .employee-sub {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
        }

        .credits-badge {
            background: #00a89f;
            color: #fff;
            border-radius: 6px;
            padding: 6px 14px;
            text-align: center;
        }

        .credits-badge .num {
            font-size: 18px;
            font-weight: 700;
            display: block;
        }

        .credits-badge .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Stats row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-box {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
        }

        .stat-box .num {
            font-size: 22px;
            font-weight: 700;
        }

        .stat-box .lbl {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-top: 2px;
        }

        .stat-box.total   .num { color: #111827; }
        .stat-box.pending .num { color: #d97706; }
        .stat-box.approved .num { color: #16a34a; }
        .stat-box.rejected .num { color: #dc2626; }

        /* Section heading */
        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        thead tr {
            background: #00a89f;
            color: #fff;
        }

        thead th {
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge-pending  { background: #fef3c7; color: #b45309; }
        .badge-approved { background: #dcfce7; color: #15803d; }
        .badge-rejected { background: #fee2e2; color: #b91c1c; }

        .no-data {
            text-align: center;
            padding: 24px;
            color: #9ca3af;
            font-style: italic;
        }

        /* Footer */
        .report-footer {
            margin-top: 24px;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #9ca3af;
        }

        /* Print button (hidden on print) */
        .print-action {
            text-align: right;
            margin-bottom: 16px;
        }

        .btn-print {
            background: #00a89f;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-back {
            background: transparent;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 8px;
            text-decoration: none;
            display: inline-block;
        }

        @media print {
            .print-action { display: none !important; }
        }
    </style>
</head>
<body>

    {{-- Action buttons (hidden on print) --}}
    <div class="print-action">
        <a href="{{ route('employee.leaves.index') }}" class="btn-back">← Back</a>
        <button class="btn-print" onclick="window.print()">🖨 Print / Save as PDF</button>
    </div>

    {{-- Report Header --}}
    <div class="report-header">
        <div>
            <div class="school-name">{{ config('app.name') }}</div>
            <div class="report-title">Employee Leave History Report</div>
        </div>
        <div class="report-meta">
            <div>Generated: {{ now()->format('F d, Y h:i A') }}</div>
            <div>School Year: {{ now()->year }}-{{ now()->year + 1 }}</div>
        </div>
    </div>

    {{-- Employee Info --}}
    <div class="employee-card">
        <div>
            <div class="employee-name">{{ $employee->first_name }} {{ $employee->last_name }}</div>
            <div class="employee-sub">{{ $employee->position?->name ?? 'N/A' }} &bull; {{ $employee->position?->department?->name ?? 'N/A' }}</div>
            <div class="employee-sub">{{ auth()->user()->email }}</div>
        </div>
        <div class="credits-badge">
            <span class="num">{{ $availableCredits }}</span>
            <span class="label">Leave Credits Left</span>
        </div>
    </div>

    {{-- Summary Stats --}}
    <div class="stats-row">
        <div class="stat-box total">
            <div class="num">{{ $leaves->count() }}</div>
            <div class="lbl">Total Requests</div>
        </div>
        <div class="stat-box pending">
            <div class="num">{{ $pendingCount }}</div>
            <div class="lbl">Pending</div>
        </div>
        <div class="stat-box approved">
            <div class="num">{{ $approvedCount }}</div>
            <div class="lbl">Approved</div>
        </div>
        <div class="stat-box rejected">
            <div class="num">{{ $rejectedCount }}</div>
            <div class="lbl">Rejected</div>
        </div>
    </div>

    {{-- Leave History Table --}}
    <div class="section-title">Leave History</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Filed On</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaves as $i => $leave)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}</td>
                    <td>{{ $leave->days }}</td>
                    <td>{{ $leave->reason }}</td>
                    <td>
                        @if($leave->status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($leave->status === 'approved')
                            <span class="badge badge-approved">Approved</span>
                        @else
                            <span class="badge badge-rejected">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $leave->created_at->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">No leave records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="report-footer">
        <span>{{ config('app.name') }} &mdash; Confidential</span>
        <span>Total days on leave: <strong>{{ $totalDays }} day(s)</strong></span>
        <span>{{ now()->format('Y') }} &copy; All rights reserved</span>
    </div>

</body>
</html>
