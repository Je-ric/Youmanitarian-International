<html>
<head>
    <meta charset="utf-8">
    <title>Members</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Members {{ $type ? '(' . ucfirst(str_replace('_',' ', $type)) . ')' : '' }}</h1>
    <p>Generated: {{ $generated_at }}</p>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Status</th><th>Start Date</th></tr></thead>
        <tbody>
        @foreach ($members as $m)
            <tr>
                <td>{{ $m->id }}</td>
                <td>{{ optional($m->user)->name }}</td>
                <td>{{ $m->membership_type }}</td>
                <td>{{ $m->membership_status }}</td>
                <td>{{ $m->start_date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


