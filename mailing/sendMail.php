<?php

    @ini_set('display_errors', true);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';

    require '../vendor/autoload.php';

    if (isset($_POST['validBtn'])) {
        if (isset($_POST['contactName'], $_POST['contactEmail'], $_POST['contactSubject'], $_POST['contactMessage'])) {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Priority = 3;
                $mail->Host       = 'ssl0.ovh.net';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'contact@pierre-blanchard.fr';                     //SMTP username
                $mail->Password   = 'oggDnQ^*@kSnB2EJ&hVt';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)); // ignorer l'erreur de certificat.
                $mail->From = 'contact@pierre-blanchard.fr';
                $mail->Sender = 'contact@pierre-blanchard.fr';
                $mail->FromName = 'Contact Pierre Blanchard';
                $mail->DKIM_domain = 'pierre-blanchard.fr';
                $mail->DKIM_private = '/etc/dev/pierre-blanchard/rsa.private';
                // var_dump(file_get_contents('/etc/dev/pierre-blanchard/key.private'));
                $mail->DKIM_selector = '1678202394';
                $mail->DKIM_passphrase = '';
                $mail->DKIM_identity = $mail->From;
            
                //Recipients
                $mail->setFrom('contact@pierre-blanchard.fr', 'Pierre Blanchard');
                $mail->addAddress($_POST['contactEmail'], $_POST['contactName']);     //Add a recipient
                $mail->addAddress('contact@pierre-blanchard.fr', 'Pierre Blanchard');     //Add a recipient
            
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Votre demande de contact chez Pierre Blanchard : ' . trim(htmlspecialchars($_POST['contactSubject']));
                $mail->Body    = 'Votre demande de contact chez Pierre Blanchard : ' . trim(htmlspecialchars($_POST['contactMessage']));
                $mail->AltBody = trim(htmlspecialchars($_POST['contactMessage']));
            
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

    header('Location: https://website.dev.pierre-blanchard.fr#contact');