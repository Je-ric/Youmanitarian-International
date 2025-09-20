<html>
<head>
    <meta charset="utf-8">
    <title>Membership Payment</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Membership Payment</h1>
    <p>Generated: {{ $generated_at }}</p>
    <table>
        <tbody>
            <tr><th>ID</th><td>{{ $payment->id }}</td></tr>
            <tr><th>Member</th><td>{{ optional(optional($payment->member)->user)->name }}</td></tr>
            <tr><th>Type</th><td>{{ optional($payment->member)->membership_type }}</td></tr>
            <tr><th>Period</th><td>{{ $payment->payment_period }}</td></tr>
            <tr><th>Year</th><td>{{ $payment->payment_year }}</td></tr>
            <tr><th>Amount</th><td>{{ number_format((float)($payment->amount ?? 0), 2) }}</td></tr>
            <tr><th>Status</th><td>{{ $payment->payment_status }}</td></tr>
            <tr><th>Payment Date</th><td>{{ $payment->payment_date }}</td></tr>
            <tr><th>Method</th><td>{{ $payment->payment_method }}</td></tr>
            <tr><th>Recorded By</th><td>{{ optional($payment->recorder)->name }}</td></tr>
            <tr><th>Notes</th><td>{{ $payment->notes }}</td></tr>
        </tbody>
    </table>
</body>
</html>


