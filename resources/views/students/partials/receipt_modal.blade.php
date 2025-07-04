{{-- resources/views/partials/receipt_modal.blade.php --}}
<div class="modal fade receipt-modal" id="receiptModal{{ $payment->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      {{-- Header with Logo & Title --}}
      <div class="modal-header">
        <img src="{{ asset('assets/images/school_logo.png') }}" alt="Logo" style="height:40px; margin-right:10px;">
        <h5 class="modal-title">Receipt #{{ $payment->id }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      {{-- Body with Details --}}
      <div class="modal-body">
        <table class="receipt-details mb-3">
          <tr>
            <td class="label">Student:</td>
            <td class="value">{{ $invoice->student->full_name }}</td>
            <td class="label">Date:</td>
            <td class="value">{{ $payment->payment_date->format('Y-m-d') }}</td>
          </tr>
          <tr>
            <td class="label">Branch:</td>
            <td class="value">{{ $invoice->branch->name }}</td>
            <td class="label">Method:</td>
            <td class="value">{{ $payment->payment_method }}</td>
          </tr>
          @if($payment->tran_code)
          <tr>
            <td class="label">Transaction Code:</td>
            <td class="value">{{ $payment->tran_code }}</td>
            <td class="label">Invoice #:</td>
            <td class="value">{{ $invoice->id }}</td>
          </tr>
          @else
          <tr>
            <td class="label">Invoice #:</td>
            <td class="value">{{ $invoice->id }}</td>
            <td></td><td></td>
          </tr>
          @endif
        </table>

        <div class="amount-box">
          Total Paid: KSh {{ number_format($payment->amount_paid, 2) }}
        </div>
      </div>

      {{-- Footer with Actions --}}
      <div class="modal-footer justify-content-between">
        <a href="{{ route('payments.download', $payment) }}" class="btn btn-outline-success">
          <i class="mdi mdi-download"></i> Download PDF
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>

    </div>
  </div>
</div>
