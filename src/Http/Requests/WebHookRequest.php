<?php

namespace Rinjax\MailGun\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebHookRequest extends FormRequest
{
    /*public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->authorize();

    }*/

    public function authorize()
    {
        $digest = hash_hmac(
            'sha256',
            $this->input('signature.timestamp') . $this->input('signature.token'),
            config('services.mailgun.webhook', 'default')
        );

        return ($this->input('signature.signature') === $digest);
    }

    public function rules()
    {
        return [];
    }

    /*private function passesAuthorization()
    {
        $digest = hash_hmac(
            'sha256',
            $this->input('signature.timestamp') . $this->input('signature.token'),
            config('services.mailgun.webhook', 'default')
        );

        dd(config('services.mailgun.webhook', 'default'), $this, $digest);

        return ($this->input('signature.signature') === $digest);
    }

    private function failedAuthorization()
    {
        throw new UnauthorizedException;
    }*/
}