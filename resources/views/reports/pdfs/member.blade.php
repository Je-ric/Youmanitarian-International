<html>
<head>
    <meta charset="utf-8">
    <title>Member Details</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Member Details</h1>
    <p>Generated: {{ $generated_at }}</p>
    <table>
        <tbody>
            <tr><th>Name</th><td>{{ optional($member->user)->name }}</td></tr>
            <tr><th>Email</th><td>{{ optional($member->user)->email }}</td></tr>
            <tr><th>Type</th><td>{{ $member->membership_type }}</td></tr>
            <tr><th>Status</th><td>{{ $member->membership_status }}</td></tr>
            <tr><th>Start Date</th><td>{{ $member->start_date }}</td></tr>
        </tbody>
    </table>

    <h2>Payments</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Period</th>
                <th>Year</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($member->payments as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->payment_period }}</td>
                <td>{{ $p->payment_year }}</td>
                <td>{{ number_format((float)($p->amount ?? 0), 2) }}</td>
                <td>{{ $p->payment_status }}</td>
                <td>{{ $p->payment_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
