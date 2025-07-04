<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Official Branches List</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 26px;
            margin: 0;
            text-transform: uppercase;
            color: #2c3e50;
        }
        .header p {
            font-size: 14px;
            margin: 5px 0 0;
            color: #7f8c8d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #bdc3c7;
            padding: 8px 12px;
            font-size: 12px;
        }
        th {
            background-color: #2c3e50;
            color: #ecf0f1;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #ecf0f1;
        }
        tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Official Branches List</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Branch Name</th>
                <th>Phone</th>
                <th>Paybill Number</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branches as $branch)
                <tr>
                    <td>{{ $branch->id }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->phone }}</td>
                    <td>{{ $branch->pay_bill_number }}</td>
                    <td>{{ $branch->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Generated on {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
