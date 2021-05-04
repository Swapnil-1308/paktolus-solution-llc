<?php
/*
Plugin Name: Paktolus Sign-Up Form
Plugin URI: 
Description: Plugin creation for postion of Wordpress Developer
Author: Swapnil Jaiswal
Author URI: https://www.linkedin.com/in/swapniljaiswal13/
Version: 1.0
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/* 
 * Add new plugin to Dashboard menu with name : Sign Up Form
 */
add_action("admin_menu", "addMenu");
function addMenu()
{
    add_menu_page("Paktolus Solutions", "Sign Up Form", 4, "paktolus-sign-up", "signUpForm" );
}

function signUpForm()
{

/* 
 * Sign Up form creation using HTML
 */
echo "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";

echo <<<EOD

    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

          body{
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
          }
          .container{
            font-family: 'Poppins',sans-serif;
            max-width: 700px;
            width: 100%;
            margin: 50px auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
          }
          .container .title{
            font-size: 25px;
            font-weight: 500;
            position: relative;
          }
          .container .title::before{
            content: "";
            position: absolute;
            left: 0;
            top: 25px;
            height: 3px;
            width: 150px;
            border-radius: 5px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
          }
          .content form .user-details{
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 40px 0 12px 0;
          }
          form .user-details .input-box{
            margin-bottom: 15px;
            width: calc(50% - 20px);
          }
          form .input-box span.details{
            display: block;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
          }
          .user-details .input-box input,
          .user-details .input-box select{
            height: 45px;
            width: 100%;
            outline: none;
            font-size: 16px;
            border-radius: 5px;
            padding-left: 15px;
            border: 1px solid #ccc;
            border-bottom-width: 2px;
            transition: all 0.3s ease;
          }
          .user-details .input-box input:focus,
          .user-details .input-box input:valid{
            border-color: #9b59b6;
          }
          form .button{
            height: 45px;
            margin: 35px 0;
            width: 100%;
          }
          form .button input{
            height: 100%;
            width: 100%;
            border-radius: 5px;
            border: none;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
          }
          form .button input:hover{
           /* transform: scale(0.99); */
           background: linear-gradient(-135deg, #71b7e6, #9b59b6);
           }
          @media(max-width: 584px){
          .container{
           max-width: 100%;
          }
          form .user-details .input-box{
             margin-bottom: 15px;
             width: 100%;
           }
           form .category{
             width: 100%;
           }
           .content form .user-details{
             max-height: 300px;
             overflow-y: scroll;
           }
           .user-details::-webkit-scrollbar{
             width: 5px;
           }
           }
           @media(max-width: 459px){
           .container .content .category{
             flex-direction: column;
           }
         }
    </style>
    
    <div class="container">
      <div class="title">Paktolus Solutions Sign Up Form</div>
        <div class="content">
          <form action="#" method="POST">
            <div class="user-details">
              <div class="input-box">
                <span class="details">Username</span>
                <input type="text" placeholder="Enter your username" name="username" required>
              </div>
              <div class="input-box">
                <span class="details">Password</span>
                <input type="password" placeholder="Enter your password" name="password" required>
              </div>
              <div class="input-box">
                <span class="details">Security Question</span>
                <select name="security_question" required>
                    <option value="">Choose security question... </option>
                    <option value="What is your first pet&apos;s name?">
                        What is your first pet&apos;s name?
                    </option>
                    <option value="What is your favorite color?">
                        What is your favorite color?
                    </option>
                    <option value="What is your mother&apos;s favorite aunt&apos;s favorite color?">
                        What is your mother&apos;s favorite aunt&apos;s favorite color?
                    </option>
                    <option value="Where does the rain in Spain mainly fall?">
                        Where does the rain in Spain mainly fall?
                    </option>
                    <option value="If Mary had three apples, would you steal them?">
                        If Mary had three apples, would you steal them?
                    </option>
                    <option value="What brand of food did your first pet eat?">
                        What brand of food did your first pet eat?
                    </option>
                </select>
              </div>
              <div class="input-box">
                <span class="details">Security Answer</span>
                <input type="text" placeholder="Enter your security answer" name="security_answer" required>
              </div>
              <div class="input-box">
                <span class="details">Email</span>
                <input type="text" placeholder="Enter your email" name="email" required>
              </div>
              <div class="g-recaptcha brochure__form__captcha input-box" data-sitekey="6LfrbMQaAAAAAN0oGUGq8NF1Rz7MKaTLtLipH3Tr">
              </div>
            </div>
            <div class="button">
              <input type="submit" value="Register" name="submit" />
            </div>
          </form>
        </div>
      </div>
EOD;

    if (isset($_POST['submit'])){
        //For captcha verification
        if(isset($_POST['g-recaptcha-response'])) {
          $captcha = $_POST['g-recaptcha-response'];
        }
        $responseKeys = reCaptcha($captcha);

        if($responseKeys["success"]) {
          echo "<script>alert('Captcha Verification Succesful')</script>";
        } else {
          echo "<script>alert('Hello, Robot!')</script>";
          exit;
        }

        $to = $_POST['email'];
        $subject = "Swapnil Jaiswal - Assignment for Wordpress Developer (Paktolus Solutions)";
        $message = "Developed By : <b>Swapnil Jaiswal</b><br><br>
                    Please find entered details below :<br>
                        Username : <i>".$_POST['username']."</i> <br>
                        Password : <i>".password_hash($_POST['password'], PASSWORD_DEFAULT)."</i> <br>
                        Security Question : <i>".$_POST['security_question']."</i> <br>
                        Security Answer : <i>".$_POST['security_answer']."</i> <br><br>
                        
                    <u>Please Note :</u> <i>Password is BCRYPT encrypted.</i>";

        $from = "swapnil@webstacknation.com";
        $headers = "From : $from";      // For alternative approach

        try {
            smtp_mailer($to, $subject, $message, $from);        // Function call to send mail via SMTP
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        
        /* 
         * Alternative approach
         * 
        if(mail($to, $subject, $message, $headers)){
            echo "<script>alert('Mail sent successfully to : ".$to."')</script>";
        } else {
            echo "<script>alert('Daemon : Mail delivery subsystem failed.')</script>";
        }
        */
    }
}

function smtp_mailer($to, $subject, $message, $from){

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer();
    
    /*  
     *  Server settings : Currently disabled, to keep confidentiality of credentials
     *  Third-Party SMTP service is not needed since website is not hosted on localhost 
     *  To enable this service, enter your gmail username & password, also enable authenication in GMail settings
     * 
    $mail->isSMTP();                                            //Send using SMTP
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
    ));
    */

    //Recipients
    $mail->setFrom($from, 'Swapnil Jaiswal');
    $mail->addAddress($to);     //Add a recipient
    $mail->addReplyTo($from, "Reply");

    //Content
    $mail->isHTML(true);        //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }else{
        echo "<script>alert('Mail sent successfully to : ".$to."')</script>";
    }
}

function reCaptcha($recaptcha){

    if(!$recaptcha || empty($recaptcha)) {
      echo "<script>alert('Recaptcha Verification Failed.')</script>";
      exit;
    }

    $secret="6LfrbMQaAAAAAOo3BIOKXdbwzQUx-t1K5wL_Ipjh";
    $ip=$_SERVER['REMOTE_ADDR'];

    $postvars=array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
    $url="https://www.google.com/recaptcha/api/siteverify";
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $data=curl_exec($ch);
    curl_close($ch);

    return json_decode($data, true);
}