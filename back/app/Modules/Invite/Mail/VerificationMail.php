<?php

declare(strict_types=1);

namespace App\Modules\Invite\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $url;
    private string $networkName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $url, string $networkName)
    {
        $this->url = $url;
        $this->networkName = $networkName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.verification', [
            'url' => $this->url,
            'networkName' => $this->networkName,
        ]);
    }
}
