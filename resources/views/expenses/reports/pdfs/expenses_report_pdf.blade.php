<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Expenses Report</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#333; }
    .header { text-align:center; margin-bottom:15px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #999; padding:6px; }
    th { background:#f0f0f0; }
    tfoot th, tfoot td { border-top:2px solid #999; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Expenses Report</h2>
    <p>Branch: {{ $branchName ?? 'All Branches' }}</p>
    <p>Period: {{ $start_date }} – {{ $end_date }}</p>
    <p>Generated: {{ now()->format('Y-m-d H:i') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Date</th>
        <th>Category</th>
        <th>Description</th>
        <th>Branch</th>
        <th>Quantity</th>
        <th>Amount (KSh)</th>
        <th>Receipt Ref</th>
      </tr>
    </thead>
    <tbody>
      @foreach($expenses as $i => $exp)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $exp->expense_date->format('Y-m-d') }}</td>
        <td>{{ $exp->category }}</td>
        <td>{{ $exp->description }}</td>
        <td>{{ $exp->branch->name }}</td>
        <td>{{ $exp->quantity }}</td>
        <td>{{ number_format($exp->amount, 2) }}</td>
        <td>{{ $exp->recept_ref_number }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="6" style="text-align:right;">Total Expenses:</th>
        <th>{{ number_format($totalAmount, 2) }}</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
