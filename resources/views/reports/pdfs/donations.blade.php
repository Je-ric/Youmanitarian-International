<html>
<head>
    <meta charset="utf-8">
    <title>All Donations</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>All Donations</h1>
    <p>Generated: {{ $generated_at }}</p>

    <h2>Summary</h2>
    <table>
        <tr><td><strong>Total Donations:</strong></td><td>{{ $summary['total_count'] }}</td></tr>
        <tr><td><strong>Total Amount:</strong></td><td>{{ number_format($summary['total_amount'], 2) }}</td></tr>
    </table>

    <h3>By Status:</h3>
    <table>
        <tr><td><strong>Confirmed:</strong></td><td>{{ $summary['confirmed']['count'] }} donations - {{ number_format($summary['confirmed']['amount'], 2) }}</td></tr>
        <tr><td><strong>Pending:</strong></td><td>{{ $summary['pending']['count'] }} donations - {{ number_format($summary['pending']['amount'], 2) }}</td></tr>
        <tr><td><strong>Rejected:</strong></td><td>{{ $summary['rejected']['count'] }} donations - {{ number_format($summary['rejected']['amount'], 2) }}</td></tr>
    </table>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Donor</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($donations as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->is_anonymous ? 'Anonymous' : ($d->donor_name ?? 'N/A') }}</td>
                <td>{{ $d->donor_email ?? 'N/A' }}</td>
                <td>{{ number_format((float)($d->amount ?? 0), 2) }}</td>
                <td>{{ $d->payment_method }}</td>
                <td>{{ $d->donation_date->format('Y-m-d') }}</td>
                <td>{{ $d->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


