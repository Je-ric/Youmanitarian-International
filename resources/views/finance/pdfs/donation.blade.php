<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Receipt - {{ $donation->donor_name ?? 'Anonymous' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
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
        .receipt-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a2235;
            margin-bottom: 30px;
        }
        .donation-details {
            margin-bottom: 30px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #1a2235;
        }
        .detail-value {
            flex: 1;
            color: #333;
        }
        .amount-highlight {
            font-size: 18px;
            font-weight: bold;
            color: #059669;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
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
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .generated-info {
            margin-top: 20px;
            font-size: 11px;
            color: #999;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="organization-name">{{ $organization }}</div>
        <div class="organization-subtitle">Empowering Communities Through Humanitarian Aid</div>
    </div>

    <div class="receipt-title">Donation Receipt</div>

    <div class="donation-details">
        <div class="detail-row">
            <div class="detail-label">Donor Name:</div>
            <div class="detail-value">
                @if($donation->is_anonymous)
                    Anonymous
                @else
                    {{ $donation->donor_name ?? 'Not provided' }}
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Donor Email:</div>
            <div class="detail-value">{{ $donation->donor_email ?? 'Not provided' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Amount:</div>
            <div class="detail-value amount-highlight">₱{{ number_format($donation->amount, 2) }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Payment Method:</div>
            <div class="detail-value">{{ ucfirst(str_replace('_', ' ', $donation->payment_method)) }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Donation Date:</div>
            <div class="detail-value">{{ $donation->donation_date->format('F j, Y') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Status:</div>
            <div class="detail-value">
                <span class="status-badge {{ $donation->status === 'Confirmed' ? 'status-confirmed' : 'status-pending' }}">
                    {{ $donation->status }}
                </span>
            </div>
        </div>

        @if($donation->notes)
        <div class="detail-row">
            <div class="detail-label">Notes:</div>
            <div class="detail-value">{{ $donation->notes }}</div>
        </div>
        @endif

        <div class="detail-row">
            <div class="detail-label">Recorded By:</div>
            <div class="detail-value">{{ $recorder->name ?? 'Unknown' }}</div>
        </div>

        @if($donation->confirmed_at)
        <div class="detail-row">
            <div class="detail-label">Confirmed On:</div>
            <div class="detail-value">{{ $donation->confirmed_at->format('F j, Y h:i A') }}</div>
        </div>
        @endif

        <div class="detail-row">
            <div class="detail-label">Receipt ID:</div>
            <div class="detail-value">#{{ $donation->id }}</div>
        </div>

        @if($donation->receipt_url)
        <div class="detail-row">
            <div class="detail-label">Receipt:</div>
            <div class="detail-value">
                <img src="{{ storage_path('app/public/' . $donation->receipt_url) }}"
                     alt="Donation Receipt"
                     style="max-width: 200px; max-height: 200px; object-fit: contain;">
            </div>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Thank you for your generous donation!</p>
        <p>Your contribution helps us continue our mission of providing humanitarian aid and support to communities in need.</p>
    </div>

    <div class="generated-info">
        Generated on: {{ $generated_at }}
    </div>
</body>
</html>
