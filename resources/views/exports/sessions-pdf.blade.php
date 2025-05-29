<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Schedule</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>General Schedule</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Course Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sessions as $session)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $session->course->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($session->start_time)->format('H : i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($session->end_time)->format('H : i') }}</td>
                    <td>{{ ucfirst($session->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>