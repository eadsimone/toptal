<?php

namespace ServiceBus;

/**
 * Class HttpClient.
 *
 * Permits to do HTTP requests to any URL, optionally sending user data.
 */
class HttpClient
{

    /**
     * Do a HTTP GET request.
     *
     * @param string $url The service URL
     * @param array $data Data to send in the query string
     *     (will be appended to the URL).
     *
     * @return string The raw response text.
     */
    function get($url, $data = null) {
        $curl = curl_init();

        if ($data !== null) {
            $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        return curl_exec($curl);
    }

    /**
     * Do a HTTP POST request.
     *
     * @param string $url The service URL
     * @param array $data Data to send in the body of the POST request.
     *
     * @return string The raw response text.
     */
    function post($url, $data = null) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        return curl_exec($curl);
    }
}