<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Payments by Zone</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#333; }
    .header { text-align:center; margin-bottom:15px; }
    table { width:100%; border-collapse:collapse; }
    th, td { border:1px solid #999; padding:6px; }
    th { background:#f0f0f0; }
    tfoot th { background:#e0e0e0; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Payments Report by Zone</h2>
    <p>Zone: {{ $zoneName ?? 'All Zones' }}</p>
    <p>Period: {{ $start_date }} – {{ $end_date }}</p>
    <p>Generated: {{ now()->format('Y-m-d H:i') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>Date</th><th>Student</th><th>Branch</th><th>Zone</th>
        <th>Invoice #</th><th>Method</th><th>Paid</th><th>Tran Code</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payments as $pay)
      <tr>
        <td>{{ $pay->payment_date->format('Y-m-d') }}</td>
        <td>{{ $pay->invoice->student->full_name }}</td>
        <td>{{ $pay->invoice->branch->name }}</td>
        <td>{{ $pay->invoice->branch->zone->name }}</td>
        <td>{{ $pay->fee_invoice_id }}</td>
        <td>{{ $pay->payment_method }}</td>
        <td style="text-align:right;">{{ number_format($pay->amount_paid,2) }}</td>
        <td>{{ $pay->tran_code }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="6" style="text-align:right;">Total Paid:</th>
        <th style="text-align:right;">KSh {{ number_format($totalPaid,2) }}</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</body>
</html>
