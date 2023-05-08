<?php
//To use this mailer, please create a gmail account for your project, enable 2fa on the gmail account and crete an app password for the gmail account.
//Then, replace the following variables with your own.
// $mail->Username = 'gmailaccountyoucreated@gmail.com';
// $mail->Password = 'gmailaccountapppassword';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require '../modules/vendor/autoload.php';

$mail = new PHPMailer();
$mail->isSMTP();

function mailContent($fname,$text){
    $mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <!--[if gte mso 9]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="format-detection" content="date=no" />
        <meta name="format-detection" content="address=no" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="x-apple-disable-message-reformatting" />
        <!--[if !mso]><!-->
           <link href="https://fonts.googleapis.com/css?family=Kreon:400,700|Playfair+Display:400,400i,700,700i|Raleway:400,400i,700,700i|Roboto:400,400i,700,700i" rel="stylesheet" />
        <!--<![endif]-->
        <title>Queenwood Golf Club</title>
        <!--[if gte mso 9]>
        <style type="text/css" media="all">
            sup { font-size: 100% !important; }
        </style>
        <![endif]-->
       
   
        <style type="text/css" media="screen">
            /* Linked Styles */
            body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#1e52bd; -webkit-text-size-adjust:none }
            a { color:#000001; text-decoration:none }
            p { padding:0 !important; margin:0 !important }
            img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
            .mcnPreviewText { display: none !important; }
            .text-footer2 a { color: #ffffff; }
           
            /* Mobile styles */
            @media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
                .mobile-shell { width: 100% !important; min-width: 100% !important; }
               
                .m-center { text-align: center !important; }
                .m-left { text-align: left !important; margin-right: auto !important; }
               
                .center { margin: 0 auto !important; }
                .content2 { padding: 8px 15px 12px !important; }
                .t-left { float: left !important; margin-right: 30px !important; }
                .t-left-2  { float: left !important; }
               
                .td { width: 100% !important; min-width: 100% !important; }
   
                .content { padding: 30px 15px !important; }
                .section { padding: 30px 15px 0px !important; }
   
                .m-br-15 { height: 15px !important; }
                .mpb5 { padding-bottom: 5px !important; }
                .mpb15 { padding-bottom: 15px !important; }
                .mpb20 { padding-bottom: 20px !important; }
                .mpb30 { padding-bottom: 30px !important; }
                .m-padder { padding: 0px 15px !important; }
                .m-padder2 { padding-left: 15px !important; padding-right: 15px !important; }
                .p70 { padding: 30px 0px !important; }
                .pt70 { padding-top: 30px !important; }
                .p0-15 { padding: 0px 15px !important; }
                .p30-15 { padding: 30px 15px !important; }
                .p30-15-0 { padding: 30px 15px 0px 15px !important; }
                .p0-15-30 { padding: 0px 15px 30px 15px !important; }
   
   
                .text-footer { text-align: center !important; }
   
                .m-td,
                .m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }
   
                .m-block { display: block !important; }
   
                .fluid-img img { width: 100% !important; max-width: 100% !important; height: auto !important; }
   
                .column,
                .column-dir,
                .column-top,
                .column-empty,
                .column-top-30,
                .column-top-60,
                .column-empty2,
                .column-bottom { float: left !important; width: 100% !important; display: block !important; }
   
                .column-empty { padding-bottom: 15px !important; }
                .column-empty2 { padding-bottom: 30px !important; }
   
                .content-spacing { width: 15px !important; }
            }
        </style>
    </head>
    <body class="body"style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background: linear-gradient(rgb(255, 149, 0) 0%, rgb(255, 94, 58) 100%); -webkit-text-size-adjust:none;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: linear-gradient(rgb(255, 149, 0) 0%, rgb(255, 94, 58) 100%);">
            <tr>
                <td align="center" valign="top">
                    <!-- Main -->
                    <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                        <tr>
                            <td class="td" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                <!-- Header -->
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <!-- END Top bar -->
                                    <!-- Logo -->
                                    <tr>
                                        <!-- https://webpapa.xyz/census_app_logo.png -->
                                        <td bgcolor="#000" class="p30-15 img-center" style=" border-radius: 0px 0px 0px 0px; font-size:0pt; line-height:0pt; text-align:center;"><a href="#" target="_blank"><img src="https://webpapa.xyz/census_app_logo.png" width="auto" height="70" border="0" alt="" style="border-radius: 15px; float: left;"/> </a><b style="color:#fff"></b></td>
                                    </tr>
                                    <!-- END Logo -->
                                    <!-- Nav -->
                                    <!-- END Nav -->
                                </table>
                                <!-- END Header -->
                                                       
                                <!-- Footer -->
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000">
                                    <tr>
                                        <td  class="text-footer2 p30-15" style="padding: 30px 15px 50px 15px; color:#fdfdfd; font-family:monospace, Arial,sans-serif; font-size:14px;  line-height:12px; text-align:center;"><multiline>Dear '.$fname.'</multiline></td>
                                    </tr>
                                    <tr>
                                        <td  class="text-footer2 p30-15" style="padding: 30px 15px 50px 15px; color:#fdfdfd; font-family:monospace, Arial,sans-serif; font-size:10px;  line-height:12px; text-align:center;"><multiline>'.$text.'</multiline></td>
                                    </tr>
                                    <tr>
                                        <td  class="text-footer2 p30-15" style="padding: 30px 15px 50px 15px; color:#fdfdfd; font-family:monospace, Arial,sans-serif; font-size:7px;  line-height:12px; text-align:center;"><multiline>This message is intended solely for the use of the individual or organisation to whom it is addressed. It may contain privileged or confidential information. If you have received this message in error, please notify the originator immediately. If you are not the intended recipient, you should not use, copy, alter or disclose the contents of this message.</multiline></td>
                                    </tr>
                                </table>
                                <!-- END Footer -->
                            </td>
                        </tr>
                    </table>
                    <!-- END Main -->
   
                </td>
            </tr>
        </table>
    </body>
    </html>';
    return $mailContent;
}
// function to send mail to user using the content and subject provided
function send_mail($email,$fname,$text,$subject)
{
    global $mail;
    //Enable SMTP debugging
    //SMTP::DEBUG_OFF = off (for production use)
    //SMTP::DEBUG_CLIENT = client messages
    //SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = 'aniamara70@gmail.com';

    //Password to use for SMTP authentication (Use app password your gmail account)
    $mail->Password = 'urwhwuovsbvawsqb';

    //Set who the message is to be sent from
    //Note that with gmail you can only use your account address (same as `Username`)
    //or predefined aliases that you have configured within your account.
    $mail->setFrom('aniamara70@gmail.com', 'Census App');

    //Set who the message is to be sent to
    $mail->addAddress("$email", $fname);

    $mail->Subject = $subject;
$mail->isHTML(true);                                  //Set email format to HTML
$mail->Body    = mailContent($fname,$text);
}
echo send_mail($email,$fname,$text,$subject);
