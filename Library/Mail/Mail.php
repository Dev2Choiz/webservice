<?php

namespace Library\Mail;


abstract class Mail {

    public function __construct(){

    }


    /**
     * [envoyerMail qui envoit des mails : ne doit pas etre appellé par le client]
     * @param  [type] $mailExped [description]
     * @param  [type] $mailDest  [description]
     * @param  [type] $body      [description]
     * @param  [type] $subject   [description]
     * @param  [type] $template  [description]
     * @return [type]            [description]
     */
    public function envoyerMail($mailExped, $mailDest, $body, $subject, $template){
        
        

        $mail = new \PhpMailer\phpmailer();
        $mail->IsSMTP();
        $mail->IsHTML(true);
        //$mail->SMTPDebug = 2; 

        $mail->SMTPAuth = true;

        $mail->Host = "ssl://188.125.69.59:465"; // SMTP server
        //$mail->Host = "smtp.mail.yahoo.fr"; // SMTP server
        
        $mail->Username = "fourneaux@yahoo.fr";
        $mail->Password = "acnologia"; 

        $mail->From=$mailExped;
        $mail->Subject = $subject;

        
        $tpl=APP_ROOT."/Models/ViewMail/".$template.".phtml";
        //echo $tpl;

        if(file_exists($tpl)){
            //echo "ici  sjkqhj";
            ob_start(); //lance au cas ou ca ne serait pas lancé
            $save=ob_get_clean();
            ob_start();
            $content_mail = $body;
            include($tpl);
            //$tmp=ob_get_contents();
            $mail->Body = ob_get_clean();  //contient le contenu du mail a l'interieur du template
            echo $save;     //remet le contenu du buffer qui n'a pas eté arreté
        }else{
            $mail->Body = $body;
        }
        

        $mail->AddAddress($mailDest);
        //$mail->AddReplyTo($mailDest);
        
        if( @(!$mail->Send() ) ){
            $mail->SmtpClose();
            return false;//$mail->ErrorInfo;
        }else{
            $mail->SmtpClose();
            return true;
        }


    }



    







}