<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
  public function basic_email()
  {
    $data = array('name' => "Roberto Araneda");

    Mail::send(['text' => 'mail'], $data, function ($message) {
      $message->to(['roberto.araneda@asur.cl', 'andres.sanmartin@asur.cl'])->subject('Laravel Basic Testing Mail');
      $message->from('robaraneda@gmail.com');
    });
    echo "Basic Email Sent. Check your inbox.";
  }
  public function html_email()
  {
    $data = array('name' => "Virat Gandhi");
    Mail::send('mail', $data, function ($message) {
      $message->to('roberto.araneda@asur.cl')->subject('Laravel HTML Testing Mail');
      $message->from('robaraneda@gmail.com');
    });
    echo "HTML Email Sent. Check your inbox.";
  }
  public function attachment_email()
  {
    $data = array('name' => "Virat Gandhi");
    Mail::send('mail', $data, function ($message) {
      $message->to('roberto.araneda@asur.cl')->subject('Laravel Testing Mail with Attachment');
      $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
      $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
      $message->from('robaraneda@gmail.com');
    });
    echo "Email Sent with attachment. Check your inbox.";
  }

  public function covid_mail($details = null)
  {

    $details['title'] = 'Estado de muestras';
    $details['body'] = "Junto con saludar, envío estado de muestras el día de " . Carbon::now()->format('d-m-Y H:i');
    /*     $details = [
      'title' => 'Mail de roberto araneda',
      'body' => 'Chequeando el envio de email.. ultra easy',
      'array' => [
        [
          'description' => 'description1',
          'value' => 1
        ],
        [
          'description' => 'description1',
          'value' => 1
        ],
        [
          'description' => 'description1',
          'value' => 1
        ],
        [
          'description' => 'description1',
          'value' => 1
        ],
        [
          'description' => 'description1',
          'value' => 1
        ]
      ]
    ]; */

    Mail::to(['roberto.araneda@asur.cl', 'andres.sanmartin@asur.cl'])->send(new \App\Mail\MailCovid($details));


    return new \App\Mail\MailCovid($details);
    //echo "done";
    // return view('mail', compact('details', $details));

  }
}
