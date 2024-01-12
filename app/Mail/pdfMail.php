<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class pdfMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $cart;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $cart)
    {
        $this->order = $order;
        $this->cart = $cart;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pdf Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'ordersPDF.pdf',
            with: [
                'order' => $this->order,
                'cart' => $this->cart,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments()
    {
        $slug = Str::slug($this->order->created_at, '-');
        $fileName = 'ordersPDF_' . $slug . '.pdf';
        return [
            storage_path('app/public/ordersPDF/'. $fileName)
        ];
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 822add44ccf4db21c50af08e77f2f16a84714344
