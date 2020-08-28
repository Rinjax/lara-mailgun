<?php

namespace Rinjax\MailGun\Responses;

class MailGunValidateEmailAddressResponse
{
    /**
     * Response array
     * @var array
     */
    protected $response = [
        "address" => null,
        "is_disposable_address" => null,
        "is_role_address" => null,
        "reason" => null,
        "result" => null,
        "risk" => null,
    ];

    /**
     * MailGunValidateEmailAddressResponse constructor.
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        if (count($array) > 0) $this->initialise($array);
    }

    /**
     * Initialise this response and set the fields from the provided array
     * @param array $array
     */
    private function initialise(array $array)
    {
        foreach ($this->response as $k => $v) {
            if(array_key_exists($k, $array)) $v = $array[$k];
        }
    }

    /**
     * The email address that was validated
     * @return string|null
     */
    public function address():?string
    {
        return $this->response['address'];
    }

    /**
     * If the domain is in a list of disposable email addresses, this will be appropriately categorized
     * @return bool|null
     */
    public function isDisposableAddress():?bool
    {
        return $this->response['is_disposable_address'];
    }

    /**
     * Checks the mailbox portion of the email if it matches a specific role type: admin, sales, webmaster
     * @return bool|null
     */
    public function isRoleAddress():?bool
    {
        return $this->response['is_role_address'];
    }

    /**
     * List of potential reasons why a specific validation may be unsuccessful.
     * @return array|null
     */
    public function reason():?array
    {
        return $this->response['reason'];
    }

    /**
     * Return the result of the validation: deliverable, undeliverable, unknown
     * @return string|null
     */
    public function result():?string
    {
        return $this->response['result'];
    }

    /**
     * Return the risk level of the email address: low, medium, high, unknown
     * @return string|null
     */
    public function risk():?string
    {
        return $this->response['risk'];
    }

    /**
     * Return this response as an array
     * @return array
     */
    public function toArray():array
    {
        return $this->response;
    }

    /**
     * return this response as a JSON
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this->response);
    }
}