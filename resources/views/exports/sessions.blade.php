<?php
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