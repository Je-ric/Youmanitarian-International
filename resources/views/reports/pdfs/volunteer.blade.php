<html>
<head>
    <meta charset="utf-8">
    <title>Volunteer Details</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Volunteer Details</h1>
    <p>Generated: {{ $generated_at }}</p>
    <p>Name: {{ optional($volunteer->user)->name }}</p>
    <p>Status: {{ $volunteer->application_status }}</p>
    <p>Joined: {{ $volunteer->joined_at }}</p>

    <h2>Programs</h2>
    <table>
        <thead><tr><th>ID</th><th>Title</th></tr></thead>
        <tbody>
        @foreach ($volunteer->programs as $p)
            <tr><td>{{ $p->id }}</td><td>{{ $p->title }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <h2>Attendance Logs</h2>
    <table>
        <thead><tr><th>Program</th><th>Clock In</th><th>Clock Out</th><th>Hours</th><th>Status</th></tr></thead>
        <tbody>
        @foreach ($volunteer->attendanceLogs as $log)
            <tr>
                <td>{{ optional($log->program)->title }}</td>
                <td>{{ $log->clock_in }}</td>
                <td>{{ $log->clock_out }}</td>
                <td>{{ $log->hours_logged }}</td>
                <td>{{ $log->approval_status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


