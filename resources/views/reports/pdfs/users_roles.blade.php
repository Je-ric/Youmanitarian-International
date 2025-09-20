<html>
<head>
    <meta charset="utf-8">
    <title>Users with Roles</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Users with Roles</h1>
    <p>Generated: {{ $generated_at }}</p>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Roles</th></tr></thead>
        <tbody>
        @foreach ($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->roles->pluck('role_name')->implode(', ') ?: 'No roles' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


