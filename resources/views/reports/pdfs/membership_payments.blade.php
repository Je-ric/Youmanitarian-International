<html>
<head>
    <meta charset="utf-8">
    <title>Membership Payments</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Membership Payments {{ $type ? '(' . ucfirst(str_replace('_',' ', $type)) . ')' : '' }}</h1>
    <p>Generated: {{ $generated_at }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Type</th>
                <th>Period</th>
                <th>Year</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Payment Date</th>
                <th>Method</th>
                <th>Recorded By</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($payments as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ optional(optional($p->member)->user)->name }}</td>
                <td>{{ optional($p->member)->membership_type }}</td>
                <td>{{ $p->payment_period }}</td>
                <td>{{ $p->payment_year }}</td>
                <td>{{ number_format((float)($p->amount ?? 0), 2) }}</td>
                <td>{{ $p->payment_status }}</td>
                <td>{{ $p->payment_date }}</td>
                <td>{{ $p->payment_method }}</td>
                <td>{{ optional($p->recorder)->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


