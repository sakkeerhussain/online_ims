<?php

//include './Log.php';
//include './Constants.php';

/**
 * Description of mail
 *
 * @author Sakkeer Hussain
 */
class mail {
    public $to = 'cgtsoft@gmail.com, sakkeerhussainp@gmail.com, piknikdates@gmail.com';
    public $subject = 'Error Reporting from Pik Nik IMS';
    public $header = 'From: webmaster@piknikindia.in';
    public $tag = "MAIL CONTROLLER";
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
        $result = mail($this->to, $this->subject, $message, $headers);
        $description = "mail sent, query : $query, error : $error, result : $result ";
        Log::i($this->tag, $description);
    }
}

//$mail = new mail();
//$mail->send_error_mail("fhdh", "fdhdh");
