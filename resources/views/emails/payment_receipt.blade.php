@component('mail::message')
# Hello {{ $student->full_name }},

Thank you for your payment of **KSh {{ number_format($payment->amount_paid,2) }}**
on {{ $payment->payment_date->format('Y-m-d') }}.

Your receipt (Invoice #00{{ $invoice->id }}) is attached as a PDF.

If you have any questions, simply reply to this email.

Thanks,<br>
**Dean Driving School**
@endcomponent
