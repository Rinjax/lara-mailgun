<?php

namespace Rinjax\MailGun\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class WebHookRequest extends Request
{
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->authorize();

    }

    private function authorize()
    {
        if(!$this->passesAuthorization()) $this->failedAuthorization();
    }

    private function passesAuthorization()
    {
        $digest = hash_hmac(
            'sha256',
            $this->input('signature.timestamp') . $this->input('signature.token'),
            config('services.mailgun.webhook', 'default')
        );

        return ($this->input('signature.signature') === $digest);
    }

    private function failedAuthorization()
    {
        throw new UnauthorizedException;
    }
}