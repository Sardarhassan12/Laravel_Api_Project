<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #00662c;
        }
        .company-address {
            margin-top: -15;
            text-align: right;
            font-size: 14px;
            line-height: 1.5;
        }
        .heading {
            background: #e6ffe9;
            font-size: 30px;
            text-align: center;
            color: #00662c;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #e6ffe9;
            color: #00662c;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">
            NerdFlow
        </div>
        <div class="company-address">
            NASTP Alpha<br>
            Islamabad, Pakistan<br>
            nerdflow@nerdflow.com<br>
            www.nerdflow.com
        </div>
    </div>

    <div class="heading">
        Your All Tasks
    </div>

    <table>
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Description</th>
                <th>DeadLine</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->deadline }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>