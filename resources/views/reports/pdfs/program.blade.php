<html>
<head>
    <meta charset="utf-8">
    <title>Program Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1,h2 { margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
    </style>
    </head>
<body>
    <h1>Program Report</h1>
    <p>Generated: {{ $generated_at }}</p>
    <h2>{{ $program->title }}</h2>
    <p>Date: {{ $program->date }} | {{ $program->start_time }} - {{ $program->end_time }}</p>
    <p>Location: {{ $program->location }}</p>
    <p>Description: {{ $program->description }}</p>
    <p>Created By: {{ $program->creator->name ?? 'Unknown' }}</p>


    <h2>Volunteers</h2>
    <table>
        <thead><tr>
            <th>#</th>
            <th>ID</th>
            <th>Name</th>
            {{-- <th>Status</th> --}}
        </tr></thead>
        <tbody>
        @foreach ($volunteers as $v)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $v->id }}</td>
                <td>{{ optional($v->user)->name }}</td>
                {{-- <td>{{ $v->pivot->status ?? '' }}</td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Attendances</h2>
    <table>
        <thead><tr>
            <th>ID</th>
            <th>Volunteer</th>
            <th>Clock In</th>
            <th>Clock Out</th>
            <th>Hours</th>
            <th>Status</th>
        </tr></thead>
        <tbody>
        @foreach ($attendances as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ optional(optional($a->volunteer)->user)->name }}</td>
                <td>{{ $a->clock_in }}</td>
                <td>{{ $a->clock_out }}</td>
                <td>{{ $a->hours_logged }}</td>
                <td>{{ $a->approval_status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Tasks</h2>
    <table>
        <thead><tr><th>ID</th><th>Description</th><th>Status</th><th>Assignments</th></tr></thead>
        <tbody>
        @foreach ($tasks as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->task_description }}</td>
                <td>{{ $t->status }}</td>
                <td>
                    @foreach ($t->assignments as $as)
                        {{ optional(optional($as->volunteer)->user)->name }}: {{ $as->status }}@if(!$loop->last) | @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Feedback</h2>
    <table>
        <thead><tr><th>ID</th><th>Volunteer/Guest</th><th>Rating</th><th>Feedback</th><th>Submitted</th></tr></thead>
        <tbody>
        @foreach ($feedback as $f)
            <tr>
                <td>{{ $f->id }}</td>
                <td>{{ $f->user_type === 'guest' ? ($f->guest_name ?: 'Guest') : optional(optional($f->volunteer)->user)->name }}</td>
                <td>{{ $f->rating }}</td>
                <td>{{ $f->feedback }}</td>
                <td>{{ $f->submitted_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>


