<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Payment Receipt</title>
  <style>
    /* Global */
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 13px;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      padding: 20px;
      width: 100%;
    }

    /* Header */
    .header {
      background-color: #004080;
      color: #fff;
      padding: 15px 20px;
      display: flex;
      align-items: center;
      border-bottom: 4px solid #002952;
    }
    .header img {
      height: 60px;
      margin-right: 15px;
    }
    .header .school-info {
      line-height: 1.2;
    }
    .header .school-info h1 {
      margin: 0;
      font-size: 20px;
    }
    .header .school-info p {
      margin: 2px 0;
      font-size: 11px;
    }

    /* Title */
    .title {
      text-align: center;
      margin: 20px 0;
      font-size: 18px;
      color: #004080;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* Details tables */
    .details, .items {
      width: 100%;
      border-collapse: collapse;
    }
    .details td {
      padding: 6px 8px;
    }
    .details .label {
      width: 25%;
      font-weight: bold;
      color: #004080;
    }
    .items th, .items td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    .items thead th {
      background-color: #e6f2ff;
      color: #004080;
    }
    .items tfoot th {
      background-color: #f2f9ff;
      text-align: right;
      font-size: 14px;
    }

    /* Footer */
    .footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      background-color: #004080;
      color: #fff;
      text-align: center;
      padding: 10px 0;
      font-size: 11px;
      border-top: 4px solid #002952;
    }
  </style>
</head>
<body>
<style>
  .header {
    background-color:#002952;
    color: #fff;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;  /* push items to the edges */
    align-items: center;
    border-bottom: 4px solid #002952;
  }
  .header img {
    height: 60px;
  }
  .school-info {
    text-align: right;              /* right-align the text */
    line-height: 1.2;
  }
  .school-info h1 {
    margin: 0;
    font-size: 20px;
  }
  .school-info p {
    margin: 2px 0;
    font-size: 11px;
  }
</style>

<div class="header">
  <div class="logo">
    <img src="/public/assets/images/Dean-Systems-logo.png" alt="School Logo">
  </div>
  <div class="school-info">
    <h1>Dean Driving School</h1>
    <p>1234 High Street, Nairobi, Kenya</p>
    <p>Phone: +254 712 345 678 | Email: info@deansystems.co.ke</p>
  </div>
</div>


  <div class="container">
    <div class="title">Payment Receipt</div>

    <!-- Invoice & Student Details -->
    <table class="details mb-4">
      <tr>
        <td class="label">Receipt #:</td>
        <td>00{{ $payment->id }}</td>
        <td class="label">Date:</td>
        <td>{{ $payment->payment_date->format('jS F Y') }}</td>
      </tr>
      <tr>
        <td class="label">Student:</td>
        <td>{{ $student->full_name }}</td>
        <td class="label">Invoice #:</td>
        <td>00{{ $invoice->id }}</td>
      </tr>
      <tr>
        <td class="label">Branch:</td>
        <td>{{ $branch->name }}</td>
        <td class="label">Method:</td>
        <td>{{ $payment->payment_method }}</td>
      </tr>
      @if($payment->tran_code)
      <tr>
        <td class="label">Tran Code:</td>
        <td colspan="3">{{ $payment->tran_code }}</td>
      </tr>
      @endif
    </table>

    <!-- Payment Breakdown -->
    <table class="items">
      <thead>
        <tr>
          <th>Description</th>
          <th class="text-end">Amount (KSh)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Payment applied to Invoice # 00{{ $invoice->id }}</td>
          <td class="text-end">{{ number_format($payment->amount_paid, 2) }}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th>Total Paid:</th>
          <th class="text-end">KSh {{ number_format($payment->amount_paid, 2) }}</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class="footer">
    <p>Thank you for choosing Dean Driving School! Visit us at www.drivingschool.co.ke</p>
  </div>
</body>
</html>
