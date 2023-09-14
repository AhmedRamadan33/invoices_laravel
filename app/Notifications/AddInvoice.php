<?php

namespace App\Notifications;

use App\Models\Invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AddInvoice extends Notification
{
    use Queueable;
    private $InvoiceNoti;
    
    public function __construct(Invoices $InvoiceNoti)
    {
        $this->InvoiceNoti = $InvoiceNoti;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->InvoiceNoti->id,
            'title' => 'تمت اضافه فاتوره بواسطه : ',
            'user' => Auth::user()->name,

            // 'data' => $this->Invoices['body']
        ];
    }

}
