<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;

class TwilioService
{
    protected $httpClient;
    protected $twilioSid;
    protected $twilioAuthToken;
    protected $twilioWhatsAppFrom;

    public function __construct()
    {
        $this->httpClient = new GuzzleClient(['verify' => false]);
        $this->twilioSid = env('TWILIO_SID');
        $this->twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $this->twilioWhatsAppFrom = env('TWILIO_WHATSAPP_FROM');
    }

    /**
     * Send a WhatsApp message.
     *
     * @param string $to Recipient WhatsApp number (e.g., +1234567890)
     * @param string $message Message content
     * @return string Message SID
     */
    public function sendWhatsAppMessage(string $to, string $message): string
    {
        $response = $this->httpClient->post("https://api.twilio.com/2010-04-01/Accounts/{$this->twilioSid}/Messages.json", [
            'auth' => [$this->twilioSid, $this->twilioAuthToken],
            'form_params' => [
                'To' => "whatsapp:$to",
                'From' => $this->twilioWhatsAppFrom,
                'Body' => $message,
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);

        return $responseBody['sid'];
    }
}
