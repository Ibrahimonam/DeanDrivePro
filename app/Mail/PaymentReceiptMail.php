<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public Payment $payment;
    public $invoice;
    public $student;
    public $branch;

    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->invoice = $payment->invoice;
        $this->student = $this->invoice->student;
        $this->branch  = $this->invoice->branch;
    }

    /**
     * Build the message.
     */
    public function build()
{
    return $this
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject("Payment Receipt #{$this->payment->id}")
        ->markdown('emails.payment_receipt', [
            'payment' => $this->payment,
            'invoice' => $this->invoice,
            'student' => $this->student,
            'branch'  => $this->branch,
        ])
        ->attachData(
            Pdf::loadView('payments.pdfs.payment_receipt', [
                'payment' => $this->payment,
                'invoice' => $this->invoice,
                'student' => $this->student,
                'branch'  => $this->branch,
            ])->output(),
            "receipt_{$this->payment->id}.pdf",
            ['mime' => 'application/pdf']
        );
}
}
