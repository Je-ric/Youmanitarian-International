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
    <h1>Volunteers</h1>
    <p>Generated: {{ $generated_at }}</p>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Application Status</th><th>Joined At</th></tr></thead>
        <tbody>
        @foreach ($volunteers as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ optional($v->user)->name }}</td>
                <td>{{ $v->application_status }}</td>
                <td>{{ $v->joined_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


