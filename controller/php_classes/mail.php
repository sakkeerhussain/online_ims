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
        
        ob_start();
        print_r($_SESSION);
        $session = ob_get_clean();
        ob_start();
        print_r($_POST);
        $post = ob_get_clean();
        ob_start();
        print_r($_GET);
        $get = ob_get_clean();
        ob_start();
        print_r($_SERVER);
        $server = ob_get_clean();
        
        
        $message = '
            <html>
            <head>
              <title style="font-size:28px;">'.$this->subject.'</title>
            </head>
            <body style="background-color:#fff; color:#21acd7; border : 5px solid #21acd7;">
              <div style="border : 5px solid #21acd7; margin :0; padding :20px; text-align : centre;">
                <h2>'.$this->subject.'</h2>
              </div>
              <table style="border : 5px solid #21acd7; padding :20px; width: 100%;">
                <tr>
                  <td style="font-size:25px;">Query</td>
                </tr>
                <tr>
                  <td>'.$query.'</td>
                </tr>
                <tr><td  style="background-color: #21acd7; height:5px;"></td></tr>
                <tr>
                  <td style="font-size:25px; padding-top : 20px;">Error</td>
                </tr>
                <tr>
                  <td>'.$error.'</td>
                </tr>
                <tr><td  style="background-color: #21acd7; height:5px;"></td></tr>
                <tr>
                  <td style="font-size:25px; padding-top : 20px;">Session</td>
                </tr>
                <tr>
                  <td>'.$session.'</td>
                </tr>
                <tr><td  style="background-color: #21acd7; height:5px;"></td></tr>
                <tr>
                  <td style="font-size:25px; padding-top : 20px;">Post</td>
                </tr>
                <tr>
                  <td>'.$post.'</td>
                </tr>
                <tr><td  style="background-color: #21acd7; height:5px;"></td></tr>
                <tr>
                  <td style="font-size:25px; padding-top : 20px;">Get</td>
                </tr>
                <tr>
                  <td>'.$get.'</td>
                </tr>
                <tr><td  style="background-color: #21acd7; height:5px;"></td></tr>
                <tr>
                  <td style="font-size:25px; padding-top : 20px;">Server</td>
                </tr>
                <tr>
                  <td>'.$server.'</td>
                </tr>
              </table>
            </body>
            </html>
            ';
        $headers  = $this->header . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $result = mail($this->to, $this->subject, $message, $headers);
        $description = "mail sent, query : $query, error : $error, result : $result ";
        Log::i($this->tag, $description);
        
        
        //saving to an html file
//        $h = fopen("sample.html", "w");
//        fwrite($h, $message);
//        fclose($h);
    }
    
    public function send_password_changed_notification_mail($username){
        
        $message = '
            <html>
            <head>
              <title style="font-size:28px;">'.$this->subject.'</title>
            </head>
            <body style="background-color:#fff; color:#21acd7; border : 5px solid #21acd7;">
              <div style="border : 5px solid #21acd7; margin :0; padding :20px; text-align : centre;">
                <h2>Login Password Changed</h2>
              </div>
              <table style="border : 5px solid #21acd7; padding :20px; width: 100%;">
                <tr>
                  <td>Login passoword of \''.$username.'\' has been updated.'."\n"
                    .'If you are not done this your system security.'."\n"
                    .'Please contact your system admin immediatly.
                  </td>
                </tr>
              </table>
            </body>
            </html>
            ';
        $headers  = $this->header . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $result = mail($this->to, $this->subject, $message, $headers);
        $description = "password changed notification mail has been sent, user name : $username ";
        Log::i($this->tag, $description);
        
        
        //saving to an html file
//        $h = fopen("sample.html", "w");
//        fwrite($h, $message);
//        fclose($h);
    }
}

//$mail = new mail();
//$mail->send_error_mail("fhdh", "fdhdh");
