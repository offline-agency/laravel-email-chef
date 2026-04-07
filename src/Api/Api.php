<?php

declare(strict_types=1);

namespace OfflineAgency\LaravelEmailChef\Api;

use Illuminate\Http\Client\Response;
use OfflineAgency\LaravelEmailChef\LaravelEmailChef;

class Api extends LaravelEmailChef
{
    /**
     * @param array<string, mixed> $query_parameters
     */
    protected function get(
        string $url,
        array $query_parameters = [],
    ): object {
        $complete_url = $this->baseUrl.$url;

        $response = $this->header->get($complete_url, $query_parameters);

        $response_status = $response->status();

        if ($response_status === 403 || $response_status === 429) {
            $this->waitThrottle($response_status);

            $this->get($url, $query_parameters);
        }

        return $this->parseResponse($response);
    }

    /**
     * @param array<string, mixed> $body
     */
    protected function post(
        string $url,
        array $body,
    ): object {
        $complete_url = $this->baseUrl.$url;

        $response = $this->header->post($complete_url, $body);

        return $this->parseResponse($response);
    }

    /**
     * @param array<string, mixed> $body
     */
    protected function put(
        string $url,
        array $body,
    ): object {
        $complete_url = $this->baseUrl.$url;

        $response = $this->header->put($complete_url, $body);

        $response_status = $response->status();

        if ($response_status === 403 || $response_status === 429) {
            $this->waitThrottle($response_status);

            $this->put($url, $body);
        }

        return $this->parseResponse($response);
    }

    /**
     * @param array<string, mixed> $query_parameters
     */
    protected function destroy(
        string $url,
        array $query_parameters = [],
    ): object {
        $complete_url = $this->baseUrl.$url;

        $response = $this->header->delete($complete_url, $query_parameters);

        $response_status = $response->status();

        if ($response_status === 403 || $response_status === 429) {
            $this->waitThrottle($response_status);

            $this->destroy($url, $query_parameters);
        }

        return $this->parseResponse($response);
    }

    private function waitThrottle(
        int $status,
    ): void {
        match ($status) {
            403     => usleep(config('email-chef.limits.403')),
            429     => usleep(config('email-chef.limits.429')),
            default => usleep(config('email-chef.limits.default')),
        };
    }

    private function parseResponse(Response $response): object {
        return (object) [
            'success' => $response->status() === 200,
            'data'    => json_decode($response->body()),
        ];
    }
}
