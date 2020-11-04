<?php

namespace App\Http\Controllers;

use App\Mail\SignupEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

// require '/etc/nginx/html/aws/aws-autoloader.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\URL;

class MailController extends Controller
{
    public static function sendSignupEmail($name, $email, $verification_code){

        $baseurl = URL::to('/');
        $SesClient = new SesClient([
            'version' => '2010-12-01',
            'region'  => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET'),
        ]]);

        $sender_email = env('MAIL_FROM_ADDRESS');
        $to = $email;

        $recipient_emails = [$to];

        $plaintext_body = 'Hello '.$email ;
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "Welcome to Live Show";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "Please click the below link to verify your email and activate your account!";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "<a href='".$baseurl."/verify?code=".$verification_code."'>Click Here!</a>";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "Thank you!";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "liveshow.cloud";

        $body = $plaintext_body;
        $html_body = $body;	
        $subject = "Welcome to Live Show";
        $char_set = 'UTF-8';

        try {
            $result = $SesClient->sendEmail([
                'Destination' => [
                    'ToAddresses' => $recipient_emails,
                ],
                'ReplyToAddresses' => [$sender_email],
                'Source' => $sender_email,
                'Message' => [
                'Body' => [
                    'Html' => [
                        'Charset' => $char_set,
                        'Data' => $html_body,
                    ],
                    'Text' => [
                        'Charset' => $char_set,
                        'Data' => $plaintext_body,
                    ],
                ],
                'Subject' => [
                    'Charset' => $char_set,
                    'Data' => $subject,
                ],
                ],
        
            ]);
            return true;
        } catch (AwsException $e) {
            return false;
        }
    }

    public static function sendVerificationCode($name, $email, $verification_code){

        $baseurl = URL::to('/');
        $SesClient = new SesClient([
            'version' => '2010-12-01',
            'region'  => env('SES_REGION'),
            'credentials' => [
                'key' => env('SES_KEY'),
                'secret' => env('SES_SECRET'),
        ]]);

        $sender_email = env('MAIL_FROM_ADDRESS');
        $to = $email;

        $recipient_emails = [$to];

        $plaintext_body = 'Hello '.$email ;
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "Welcome to Live Show";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "Please signup to Live Show";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "Verification code is ".$verification_code;
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "<a href='".$baseurl."/userType'>Signup</a>";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "Thank you!";
        $plaintext_body .= "<br><br>";
        $plaintext_body .= "liveshow.cloud";

        $body = $plaintext_body;
        $html_body = $body;	
        $subject = "Welcome to Live Show";
        $char_set = 'UTF-8';

        try {
            $result = $SesClient->sendEmail([
                'Destination' => [
                    'ToAddresses' => $recipient_emails,
                ],
                'ReplyToAddresses' => [$sender_email],
                'Source' => $sender_email,
                'Message' => [
                'Body' => [
                    'Html' => [
                        'Charset' => $char_set,
                        'Data' => $html_body,
                    ],
                    'Text' => [
                        'Charset' => $char_set,
                        'Data' => $plaintext_body,
                    ],
                ],
                'Subject' => [
                    'Charset' => $char_set,
                    'Data' => $subject,
                ],
                ],
        
            ]);
            return true;
        } catch (AwsException $e) {
            return false;
        }
    }
}
