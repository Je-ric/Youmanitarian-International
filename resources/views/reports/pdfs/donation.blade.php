<html>
<head>
    <meta charset="utf-8">
    <title>Donation</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Donation Receipt</h1>
    <p>Generated: {{ $generated_at }}</p>
    <table>
        <tbody>
            <tr><th>ID</th><td>{{ $donation->id }}</td></tr>
            <tr><th>Donor</th><td>{{ $donation->is_anonymous ? 'Anonymous' : ($donation->donor_name ?? 'N/A') }}</td></tr>
            <tr><th>Email</th><td>{{ $donation->donor_email ?? 'N/A' }}</td></tr>
            <tr><th>Amount</th><td>{{ number_format((float)($donation->amount ?? 0), 2) }}</td></tr>
            <tr><th>Method</th><td>{{ $donation->payment_method }}</td></tr>
            <tr><th>Date</th><td>{{ $donation->donation_date->format('Y-m-d') }}</td></tr>
            <tr><th>Status</th><td>{{ $donation->status }}</td></tr>
            <tr><th>Recorded By</th><td>{{ optional($donation->recorder)->name ?? 'Unknown' }}</td></tr>
            <tr><th>Confirmed At</th><td>{{ $donation->confirmed_at ? $donation->confirmed_at->format('Y-m-d H:i:s') : 'N/A' }}</td></tr>
            <tr><th>Notes</th><td>{{ $donation->notes ?? 'N/A' }}</td></tr>
        </tbody>
    </table>
</body>
</html>


