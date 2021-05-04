# paktolus-solution-llc
Assignment for Wordpress Developer - Swapnil Jaiswal

Paste the folder "Paktolus - Swapnil" into the plugins directory (public_html/wp-content/plugins..).

Plugin Name : **Paktolus Sign-Up Form**.
Once the plugin is activated, new menu "**Sign Up Form**" will be added in the admin_menu.

To **enable Re-captcha**, domain name will be required to verify the source IP, else it won't work.

PHPMailer's default SMTP is incorporated, since the plugin was hosted on live server. 
To test on local server, the following code must be uncommented in index.php.
    _$mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPDebug  = 3;                                      //Enable verbose debug output
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = 'tls';                                  //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;    
    $mail->CharSet    = 'UTF-8'; 
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));_
and **valid GMail username and password** must be entered in fields _$mail->Username_ and _$mail->Password_ respectively.
