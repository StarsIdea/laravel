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
    public static function sendSignupEmail($request, $name, $email, $verification_code){

        $baseurl = URL::to('/');
        $SesClient = new SesClient([
            'version' => '2010-12-01',
            'region'  => 'us-east-1',
            'credentials' => [
                'key' => "AKIAZYQOXGOEHNL5KMGN",
                'secret' => "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",
        ]]);

        $sender_email = 'support@liveshow.cloud';
        $to = $request->email;

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
            $messageId = $result['MessageId'];
            return true;
            // echo("Email sent! Message ID: $messageId"."\n");
        } catch (AwsException $e) {
            // output error message if fails
            // echo $e->getMessage();
            // echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
            // echo "\n";
            return false;
            // return $e->getMessage();
            // return "The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n";
        }
    }
}
