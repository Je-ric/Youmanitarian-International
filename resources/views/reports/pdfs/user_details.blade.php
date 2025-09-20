<html>
<head>
    <meta charset="utf-8">
    <title>User Details Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1,h2 { margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        .section { margin: 20px 0; }
    </style>
</head>
<body>
    <h1>User Details Report</h1>
    <p>Generated: {{ $generated_at }}</p>

    <div class="section">
        <h2>User Information</h2>
        <table>
            <tr><td><strong>ID:</strong></td><td>{{ $user->id }}</td></tr>
            <tr><td><strong>Name:</strong></td><td>{{ $user->name }}</td></tr>
            <tr><td><strong>Email:</strong></td><td>{{ $user->email }}</td></tr>
            <tr><td><strong>Created At:</strong></td><td>{{ $user->created_at->format('M j, Y \a\t g:i A') }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Roles</h2>
        @if($user->roles->count() > 0)
            <table>
                <thead><tr><th>Role Name</th></tr></thead>
                <tbody>
                @foreach ($user->roles as $role)
                    <tr><td>{{ $role->role_name }}</td></tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No roles assigned</p>
        @endif
    </div>

    @if($user->volunteer)
    <div class="section">
        <h2>Volunteer Details</h2>
        <table>
            <tr><td><strong>Application Status:</strong></td><td>{{ $user->volunteer->application_status }}</td></tr>
            <tr><td><strong>Total Hours:</strong></td><td>{{ $user->volunteer->total_hours ?? 0 }}</td></tr>
            <tr><td><strong>Joined At:</strong></td><td>{{ $user->volunteer->created_at->format('M j, Y \a\t g:i A') }}</td></tr>
        </table>
    </div>
    @endif

    @if($user->member)
    <div class="section">
        <h2>Member Details</h2>
        <table>
            <tr><td><strong>Membership Type:</strong></td><td>{{ $user->member->membership_type }}</td></tr>
            <tr><td><strong>Membership Status:</strong></td><td>{{ $user->member->membership_status }}</td></tr>
            <tr><td><strong>Start Date:</strong></td><td>{{ $user->member->start_date }}</td></tr>
        </table>
    </div>
    @endif
</body>
</html>
