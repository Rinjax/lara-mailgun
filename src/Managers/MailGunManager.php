<?php

namespace Rinjax\MailGun\Managers;

use Mailgun\Mailgun;
use Mailgun\Model\Message\SendResponse;

class MailGunManager
{
    protected $MG_CLIENT;

    protected $DOMAIN;

    protected $PARAMS = [];

    public function __construct()
    {
        $this->MG_CLIENT = Mailgun::create(
            config('services.mailgun.secret'),
            config('services.mailgun.endpoint')
        );

        $this->DOMAIN = config('services.mailgun.domain');
    }

    /**
     * Change the domain at the email will be associated with
     * @param string $domain
     * @return MailGunManager
     */
    public function changeDomain(string $domain): MailGunManager
    {
        $this->DOMAIN = $domain;

        return $this;
    }

    /**
     * Set the To address (destination). can be a comma separated string for multiple addresses EG "one@domain.com,two@domain.com"
     * @param string $email_address
     * @return MailGunManager
     */
    public function to(string $email_address) : MailGunManager
    {
        $this->PARAMS['to'] = $email_address;

        return $this;
    }

    /**
     * Set the From address (sender)
     * @param string $email_address
     * @param string $name
     * @return MailGunManager
     */
    public function from(string $email_address, string $name): MailGunManager
    {
        $this->PARAMS['from'] = $name . ' <' . $email_address . '>';

        return $this;
    }

    /**
     * Set the CC address (carbon copy address)
     * @param string $email_address
     * @return MailGunManager
     */
    public function cc(string $email_address): MailGunManager
    {
        $this->PARAMS['cc'] = $email_address;

        return $this;
    }

    /**
     * Set the BCC address (blind carbon copy)
     * @param string $email_address
     * @return MailGunManager
     */
    public function bcc(string $email_address): MailGunManager
    {
        $this->PARAMS['bcc'] = $email_address;

        return $this;
    }

    /**
     * Set the subject line of the email
     * @param string $subject
     * @return MailGunManager
     */
    public function subject(string $subject): MailGunManager
    {
        $this->PARAMS['subject'] = $subject;

        return $this;
    }

    /**
     * Set the text if sending as plain text email
     * @param string $text
     * @return MailGunManager
     */
    public function text(string $text): MailGunManager
    {
        $this->PARAMS['text'] = $text;

        return $this;
    }

    /**
     * Set the html of the email if sending as a html email.
     * @param string $html
     * @return MailGunManager
     */
    public function html(string $html): MailGunManager
    {
        $this->PARAMS['html'] = $html;

        return $this;
    }

    /**
     * Set tracking of the email
     * @param bool $bool
     * @return MailGunManager
     */
    public function tracking(bool $bool = true): MailGunManager
    {
        $this->PARAMS["o:tracking"] = $bool;

        return $this;
    }

    /**
     * Add a custom variable to the email. These can be retrieved later, IE in webhooks. You can set custom var for user
     * id, so you can link back to the user in a database, for example.
     * @param string $name
     * @param string $value
     * @return MailGunManager
     */
    public function addVariable(string $name, string $value): MailGunManager
    {
        $this->PARAMS["v:$name"] = $value;

        return $this;
    }

    /**
     * As addVariable() function, but accepts an array of key:value pairs to mass assign variables.
     * @param array $array
     * @return MailGunManager
     */
    public function addVariables(array $array): MailGunManager
    {
        foreach ($array as $var => $val) {
            $this->PARAMS["v:$var"] = $val;
        }

        return $this;
    }

    /**
     * Send the email
     */
    public function send():SendResponse
    {
        return $this->MG_CLIENT->messages()->send($this->DOMAIN, $this->PARAMS);
    }
}