<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Donations Report - {{ $organization }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a2235;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .organization-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a2235;
            margin-bottom: 5px;
        }
        .organization-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .report-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a2235;
            margin-bottom: 20px;
        }
        .summary-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #1a2235;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .donations-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .donations-table th {
            background-color: #1a2235;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        .donations-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }
        .donations-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-confirmed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .amount-column {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        .generated-info {
            margin-top: 20px;
            font-size: 10px;
            color: #999;
            text-align: right;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="organization-name">{{ $organization }}</div>
        <div class="organization-subtitle">Empowering Communities Through Humanitarian Aid</div>
    </div>

    <div class="report-title">All Donations Report</div>

    <div class="summary-stats">
        <div class="stat-item">
            <div class="stat-value">{{ $total_count }}</div>
            <div class="stat-label">Total Donations</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">₱{{ number_format($total_amount, 2) }}</div>
            <div class="stat-label">Total Amount</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $donations->where('status', 'Confirmed')->count() }}</div>
            <div class="stat-label">Confirmed</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $donations->where('status', 'Pending')->count() }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <table class="donations-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Donor Name</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Status</th>
                <th>Anonymous</th>
                <th>Notes</th>
                <th>Recorded By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
            <tr>
                <td>#{{ $donation->id }}</td>
                <td>
                    @if($donation->is_anonymous)
                        Anonymous
                    @else
                        {{ $donation->donor_name ?? 'N/A' }}
                    @endif
                </td>
                <td>{{ $donation->donor_email ?? 'N/A' }}</td>
                <td class="amount-column">₱{{ number_format($donation->amount, 2) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $donation->payment_method)) }}</td>
                <td>{{ $donation->donation_date->format('M d, Y') }}</td>
                <td>
                    <span class="status-badge {{ $donation->status === 'Confirmed' ? 'status-confirmed' : 'status-pending' }}">
                        {{ $donation->status }}
                    </span>
                </td>
                <td>{{ $donation->is_anonymous ? 'Yes' : 'No' }}</td>
                <td>{{ Str::limit($donation->notes ?? 'N/A', 30) }}</td>
                <td>{{ $donation->recorder->name ?? 'Unknown' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report contains all donation records for {{ $organization }}</p>
        <p>Generated for administrative and record-keeping purposes</p>
    </div>

    <div class="generated-info">
        Generated on: {{ $generated_at }}
    </div>
</body>
</html>
