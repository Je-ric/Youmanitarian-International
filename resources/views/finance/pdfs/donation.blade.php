<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Receipt - {{ $donation->donor_name ?? 'Anonymous' }}</title>
    <style>
        /* --- PDF Page Setup --- */
        @page {
            size: A4 portrait; /* Paper size (A4), orientation portrait */
            margin: 25mm;      /* Standard margins for readability */
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.5;
            font-size: 12px; /* Slightly smaller for fitting long content */
        }

        /* --- Header Section --- */
        .header {
            text-align: center;
            border-bottom: 2px solid #1a2235;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .organization-name {
            font-size: 20px;
            font-weight: bold;
            color: #1a2235;
            margin-bottom: 3px;
        }
        .organization-subtitle {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .receipt-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a2235;
            text-align: center;
            margin: 20px 0;
        }

        /* --- Donation Details Section --- */
        .donation-details {
            margin-bottom: 20px;
        }
        .detail-row {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 6px;
            page-break-inside: avoid; /* Prevent detail row from splitting across pages */
        }
        .detail-label {
            font-weight: bold;
            width: 140px; /* Fixed width for labels */
            color: #1a2235;
            font-size: 12px;
        }
        .detail-value {
            flex: 1;
            color: #333;
            font-size: 12px;
        }

        /* --- Special Styling --- */
        .amount-highlight {
            font-size: 14px;
            font-weight: bold;
            color: #059669;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
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

        /* --- Footer Section --- */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        .generated-info {
            margin-top: 15px;
            font-size: 10px;
            color: #999;
            text-align: right;
        }

        /* --- Image Styling --- */
        img.receipt-image {
            max-width: 180px;   /* Keep image small to fit nicely */
            max-height: 180px;
            object-fit: contain; /* Maintain aspect ratio */
            border: 1px solid #ccc;
            padding: 3px;
        }

        /* --- Page Break Handling --- */
        .page-break {
            page-break-before: always; /* Manual page breaks if needed */
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="organization-name">{{ $organization }}</div>
        <div class="organization-subtitle">Empowering Communities Through Humanitarian Aid</div>
    </div>

    <div class="receipt-title">Donation Receipt</div>

    <!-- Donation Details -->
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
                @php
                    $absolutePath = public_path('storage/' . $donation->receipt_url);
                @endphp
                @if(file_exists($absolutePath))
                {{-- new --}}
                    <img src="{{ $absolutePath }}"
                        alt="Donation Receipt"
                        class="receipt-image">
                @else
                    <span>Receipt file not found.</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your generous donation!</p>
        <p>Your contribution helps us continue our mission of providing humanitarian aid and support to communities in need.</p>
    </div>

    <div class="generated-info">
        Generated on: {{ $generated_at }}
    </div>
</body>
</html>
