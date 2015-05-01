<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mail
 *
 * @author Sakkeer Hussain
 */
class mail {
    public $to = 'cgtsoft@gmail.com,sakkeerhussainp@gmail.com,piknikdates@gmail.com';
    public $subject = 'Error Reporting from Pik Nik IMS';
    public $header = 'From: webmaster@piknikindia.in';
    public function send_error_mail($query, $error){
        $message = '
            <html>
            <head>
              <title>'.$this->subject.'</title>
            </head>
            <body>
              <p>'.$this->subject.'</p>
              <table>
                <tr>
                  <td>Query</td><td> : </td><td>'.$query.'</td>
                </tr>
                <tr>
                  <td>Error</td><td> : </td><td>'.$error.'</td>
                </tr>
              </table>
            </body>
            </html>
            ';
        $headers  = $this->header;
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        mail($thi->to, $this->subject, $message, $headers);
    }
}
