<?php

namespace Controller;

class Message {

    public function send($msgData){
        if(!empty($msgData) && gettype($msgData) === 'array'){

            $to      = 'postmaster@localhost';
            $subject = 'Kontak besked fra ' . $msgData['firstname'] . ' ' . $msgData['lastname'];
            $message = $msgData['message'];
            $headers = 'From: ' . $msgData['email'] . "\r\n" .
                        'Reply-To: ' . $msgData['email'] . "\r\n" .
                        'X-Mailer: PHP/Landrupdans.Mailer';

            return mail($to, $subject, $message, $headers);
        }
        return false;
    }

}