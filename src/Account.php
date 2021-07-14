<?php


namespace Zbanx\CasClient;


class Account
{
    public $account_id;
    public $username;
    public $nickname;
    public $email;
    public $mobile;
    public $type;
    public $status;

    public function __construct($account)
    {
        $this->account_id = $account['account_id'];
        $this->username = $account['username'];
        $this->nickname = $account['nickname'];
        $this->email = $account['email'];
        $this->mobile = $account['mobile'];
        $this->type = $account['type'];
        $this->status = $account['status'];
    }
}