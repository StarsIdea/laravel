<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

require '/etc/nginx/html/aws/aws-autoloader.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

class SignupEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email_data;

    public function __construct($data)
    {
        $this->email_data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $data = array(
        //   'name' => $request->name,
        //   'email' => $request->email,
        //   'subject' => $request->subject,
        //   'mail_message' => $request->mail_message,
        // );

        // Mail::send('emails.contact_mail', compact('data'), function($message) use ($data){
        //   $message->from($data['email']);
        //   $message->to(env('MAIL_USERNAME'));
        //   $message->subject($data['subject']);
        // });
        // return $this->from(env('MAIL_USERNAME', 'AKIAZYQOXGOEGIXBW3SJ'))->subject('Welcome to Liveshow.cloud')->view('mail.signup-email',['email_data' => $this->email_data]);
        
        // return $this->markdown('mail.signup-email')->with([
        //     'email_data' =>$this->email_data
        // ]);

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

        $plaintext_body = 'This email was sent by liveshow.cloud.' ;

        $body = "test";
        $html_body = $body;			  
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
            echo("Email sent! Message ID: $messageId"."\n");
        } catch (AwsException $e) {
            // output error message if fails
            echo $e->getMessage();
            echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
            echo "\n";
        }
    }
}
