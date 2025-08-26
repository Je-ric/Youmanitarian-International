<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Donations Report - {{ $organization }}</title>
    <style>
        /* --- PDF Page Setup --- */
        @page {
            size: A4 landscape; /* Landscape is better for wide tables */
            margin: 15mm;       /* Slightly reduced margins to fit more columns */
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.4;
            font-size: 11px; /* Smaller font to fit more data */
        }

        /* --- Header --- */
        .header {
            text-align: center;
            border-bottom: 2px solid #1a2235;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .organization-name {
            font-size: 20px;
            font-weight: bold;
            color: #1a2235;
        }
        .organization-subtitle {
            font-size: 11px;
            color: #666;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #1a2235;
            text-align: center;
            margin: 15px 0;
        }

        /* --- Summary Stats --- */
        .summary-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8fafc;
            border-radius: 6px;
            font-size: 11px;
        }
        .stat-item {
            text-align: center;
            flex: 1;
        }
        .stat-value {
            font-size: 14px;
            font-weight: bold;
            color: #1a2235;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
        }

        /* --- Table --- */
        .donations-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed; /* Prevents uneven column widths */
            word-wrap: break-word; /* Wraps long text instead of overflowing */
        }
        .donations-table th {
            background-color: #1a2235;
            color: white;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        .donations-table td {
            padding: 5px 6px;
            border-bottom: 1px solid #eee;
            font-size: 10px;
            vertical-align: top;
        }
        .donations-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        /* --- Column Fixes --- */
        .amount-column {
            text-align: right;
            font-weight: bold;
        }
        .notes-column {
            max-width: 120px; /* Prevent notes from stretching table */
            white-space: normal;
        }

        /* --- Status Badges --- */
        .status-badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 9px;
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

        /* --- Proof Image --- */
        img.proof-image {
            width: 50px;  /* Thumbnail size */
            height: auto;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        /* --- Footer --- */
        .footer {
            margin-top: 20px;
            padding-top: 12px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .generated-info {
            margin-top: 10px;
            font-size: 9px;
            color: #999;
            text-align: right;
        }

        /* --- Page Break --- */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="organization-name">{{ $organization }}</div>
        <div class="organization-subtitle">Empowering Communities Through Humanitarian Aid</div>
    </div>

    <div class="report-title">All Donations Report</div>

    <!-- Summary Stats -->
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

    <!-- Table -->
    <table class="donations-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Donor Name</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Anon</th>
                <th class="notes-column">Notes</th>
                <th>Recorder</th>
                <th>Proof</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
            <tr>
                <td>#{{ $donation->id }}</td>
                <td>{{ $donation->is_anonymous ? 'Anonymous' : ($donation->donor_name ?? 'N/A') }}</td>
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
                <td class="notes-column">{{ \Illuminate\Support\Str::limit($donation->notes ?? 'N/A', 50) }}</td>
                <td>{{ $donation->recorder->name ?? 'Unknown' }}</td>
                <td>
                    @if($donation->proof_image)
                        @php
                            $absolutePath = public_path('storage/' . $donation->proof_image);
                        @endphp

                        @if(file_exists($absolutePath))
                            <img src="{{ $absolutePath }}"
                                 alt="Donation Receipt"
                                 style="width:60px; height:auto; border-radius:4px;">
                        @else
                            N/A
                        @endif
                    @else
                        N/A
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>This report contains all donation records for {{ $organization }}</p>
        <p>Generated for administrative and record-keeping purposes</p>
    </div>

    <div class="generated-info">
        Generated on: {{ $generated_at }}
    </div>
</body>
</html>
