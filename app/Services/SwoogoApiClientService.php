<?php

namespace App\Services;

class SwoogoApiClientService
{

    private $accessToken = "";

    private function getAccessToken($key, $secret) {

        if($this->accessToken != "") {
            return [
                "response" => 1,
                "payload" => "true"
            ];
        }

        if($key === "" || $key === "") {
            return [
                "response" => 0,
                "payload" => "Api Access Key must be provided."
            ];
        }

        $token_endpoint = 'https://api.swoogo.com/api/v1/oauth2/token.json';

        // prepare request data
        $data = [
            'grant_type' => 'client_credentials'
        ];

        // set headers
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($key . ':' . $secret)
        ];

        // initialize cURL
        $curl = curl_init();

        // set options
        curl_setopt_array($curl, [
            CURLOPT_URL => $token_endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => $headers
        ]);

        // execute request
        $response = curl_exec($curl);

        // check for errors
        if (curl_errno($curl)) {
            return [
                "response" => 0,
                "payload" => curl_error($curl)
            ];
        }

        // decode response
        $json = json_decode($response, true);

        // extract access token
        $this->accessToken = $json['access_token'];

        // close cURL
        curl_close($curl);

        return [
            "response" => 1,
            "payload" => "true"
        ];
    }

    /**
     * Fetch session events from the Swoogo API
     *
     * @param string $eventId The event ID being scanned
     * @param string $key The API key
     * @param string $secret The API secret
     *
     * @return array The event statistics
     */
    public function getApiSwoogoSessions($eventId, $key, $secret)
    {
        // Fetch the data from the Swoogo API using the provided credentials

        $url = "https://api.swoogo.com/api/v1/sessions.json?event_id={$eventId}";
        
        $accessTokenResponse = $this->getAccessToken($key, $secret);
        if($accessTokenResponse["response"] === 0) {
            return $accessTokenResponse;
        }
        
        $headers = [
            'Authorization: Bearer ' . $this->accessToken,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ]);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return [
                "response" => 0,
                "payload" => curl_error($curl)
            ];
        }

        curl_close($curl);

        $stats = json_decode($response, true);

        return [
            "response" => 1,
            "payload" => $stats
        ];
    }

    public function getSwoogoSessionDetails($id, $key = '', $secret = '') {
        // Fetch the data from the Swoogo API using the provided credentials

        $url = "https://api.swoogo.com/api/v1/sessions/{$id}.json?fields=&expand=";
        
        $accessTokenResponse = $this->getAccessToken($key, $secret);
        if($accessTokenResponse["response"] === 0) {
            return $accessTokenResponse;
        }
        
        $headers = [
            'Authorization: Bearer ' . $this->accessToken,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ]);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return [
                "response" => 0,
                "payload" => curl_error($curl)
            ];
        }

        curl_close($curl);

        $stats = json_decode($response, true);

        return [
            "response" => 1,
            "payload" => $stats
        ];
    }
}