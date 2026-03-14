<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class LaravelEmailChef
{
    private mixed $username;

    private mixed $password;

    protected mixed $login_url;

    protected mixed $baseUrl;

    private mixed $authkey;

    protected PendingRequest $header;

    public function __construct() {
        $this->setUsername();

        $this->setPassword();

        $this->setLoginUrl();

        $this->setBaseUrl();

        $this->login();

        $this->setHeader();
    }

    /**
     * @throws Exception
     */
    public function login(): void {
        $url = $this->getLoginUrl().'login';
        $username = $this->getUsername();
        $password = $this->getPassword();

        if (is_null($username) || is_null($password)) {
            throw new Exception('Missing Credentials! Please add your credentials on .env file.');
        }
        $result = Http::withHeaders([
            'Accept' => 'application/json; charset=utf-8',
        ])->post($url, [
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
        ]);

        // TODO: check result status and handle errors

        $result = json_decode($result->body());

        if ($result->message === 'error_credential_wrong') {
            throw new Exception('Auth Error! Wrong Credentials. Please check your credentials.');
        }

        $this->setAuthKey($result->authkey);
    }

    private function setHeader(): void {
        $this->header = Http::withHeaders([
            'Accept'  => 'application/json; charset=utf-8',
            'authkey' => $this->getAuthKey(),
        ]);
    }

    private function getPassword(): mixed {
        return $this->password;
    }

    private function setPassword(): void {
        $this->password = config('email-chef.password');
    }

    private function getUsername(): mixed {
        return $this->username;
    }

    private function setUsername(): void {
        $this->username = config('email-chef.username');
    }

    public function getAuthKey(): mixed {
        return $this->authkey;
    }

    private function setAuthKey(mixed $authKey): void {
        $this->authkey = $authKey;
    }

    private function setBaseUrl(): void {
        $this->baseUrl = config('email-chef.baseUrl');
    }

    public function getLoginUrl(): mixed {
        return $this->login_url;
    }

    public function setLoginUrl(): void {
        $this->login_url = config('email-chef.login_url');
    }
}
