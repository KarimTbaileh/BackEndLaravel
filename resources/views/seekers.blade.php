<!DOCTYPE html>
<html>
<head>
    <title>Job Seekers</title>
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 50px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
<h2 style="text-align: center;">All Job Seekers</h2>
<table>
    <tr>
        <th>ID</th>
        <th>User Email</th>
        <th>Country</th>
        <th>Date of Birth</th>
        <th>Gender</th>
    </tr>
    @foreach($seekers as $seeker)
        <tr>
            <td>{{ $seeker->id }}</td>
            <td>{{ $seeker->user->email }}</td>
            <td>{{ $seeker->country }}</td>
            <td>{{ $seeker->day }}/{{ $seeker->month }}/{{ $seeker->year }}</td>
            <td>{{ $seeker->gender }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
