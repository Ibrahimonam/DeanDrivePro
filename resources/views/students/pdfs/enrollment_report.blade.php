<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Enrollment Report</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#333; }
    .header { text-align:center; margin-bottom:15px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #999; padding:6px; }
    th { background:#f0f0f0; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Enrollment Report</h2>
    <p>Branch: {{ $branchName ?? 'All Branches' }}</p>
    <p>Period: {{ $start_date }} – {{ $end_date }}</p>
    <p>Generated: {{ now()->format('Y-m-d H:i') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th><th>Enrolled On</th><th>Full Name</th><th>ID #</th>
        <th>Branch</th><th>Class</th><th>Email</th><th>Phone</th>
      </tr>
    </thead>
    <tbody>
      @foreach($students as $i => $stu)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $stu->created_at->format('Y-m-d') }}</td>
        <td>{{ $stu->full_name }}</td>
        <td>{{ $stu->id_number }}</td>
        <td>{{ $stu->branch->name }}</td>
        <td>{{ $stu->class->name }}</td>
        <td>{{ $stu->email }}</td>
        <td>{{ $stu->phone_number }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
