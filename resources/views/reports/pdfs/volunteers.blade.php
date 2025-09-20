<html>
<head>
    <meta charset="utf-8">
    <title>Volunteers</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Volunteers Report</h1>
    <p>Generated: {{ $generated_at }}</p>
    @if($status)
        <p>Filter: {{ ucfirst($status) }} volunteers only</p>
    @else
        <p>All volunteers</p>
    @endif
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Application Status</th><th>Total Hours</th><th>Joined Date</th></tr></thead>
        <tbody>
        @foreach ($volunteers as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ optional($v->user)->name ?? 'N/A' }}</td>
                <td>{{ optional($v->user)->email ?? 'N/A' }}</td>
                <td>{{ $v->application_status }}</td>
                <td>{{ $v->total_hours ?? 0 }}</td>
                <td>{{ $v->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


