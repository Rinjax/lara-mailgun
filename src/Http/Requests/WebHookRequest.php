<?php

namespace Rinjax\MailGun\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebHookRequest extends FormRequest
{

    /**
     * Check the signature of the webhook to verify that it was sent from mailgun
     * @return bool
     */
    public function authorize()
    {
        $digest = hash_hmac(
            'sha256',
            $this->input('signature.timestamp') . $this->input('signature.token'),
            config('services.mailgun.webhook', 'default')
        );

        return ($this->input('signature.signature') === $digest);
    }

    /**
     * Just to fullfill FormRequest - not used. 
     * @return array
     */
    public function rules()
    {
        return [];
    }
}