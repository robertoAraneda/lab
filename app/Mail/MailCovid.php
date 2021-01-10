<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class MailCovid extends Mailable
{
  use Queueable, SerializesModels;

  public $details;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($details)
  {
    $this->details = $details;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {

    $date = Carbon::now()->format('d/m/Y H:i:s');

    $subject = "Estado de muestras COVID-19 ".$date;

    return $this->from('robaraneda@gmail.com')
      ->subject($subject)
      ->view('mail')
      ->markdown('emails.covid');
  }
}
