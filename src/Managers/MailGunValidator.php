<?php

namespace Rinjax\MailGun\Managers;

use GuzzleHttp\Client;
use Rinjax\MailGun\Responses\MailGunValidateEmailAddressResponse;

/**
 * Class MailGunValidator
 * @package Rinjax\MailGun\Managers
 */
class MailGunValidator
{
    /**
     * HTTP client to make the API calls
     * @var Client
     */
    protected $HTTP;

    /**
     * Parameters for the API request
     * @var array
     */
    protected $PARAMS = [];

    /**
     * URL of the API Endpoint
     * @var string
     */
    protected $URL = 'https://api.mailgun.net/v4/address/validate';

    /**
     * MailGunValidator constructor.
     */
    public function __construct()
    {
        $this->HTTP = new Client([
            'timeout' => 2.0,
            'auth' => ['api', config('services.mailgun.secret')]
        ]);
    }

    /**
     * Main function to validate an address
     * @param string $email_address
     * @return MailGunValidateEmailAddressResponse
     */
    public function validateEmailAddress(string $email_address): MailGunValidateEmailAddressResponse
    {
        $this->PARAMS['address'] = $email_address;

        return new MailGunValidateEmailAddressResponse($this->sendRequest());
    }

    /**
     * Make the API call to Mailgun
     * @return mixed
     */
    private function sendRequest()
    {
        $response = $this->HTTP->post($this->URL, [
            'form_params' => $this->PARAMS
        ])->getBody()->getContents();

        return json_decode($response, true);
    }
}