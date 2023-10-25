<?php

declare(strict_types=1);

namespace App\Http\Client;

use App\Exceptions\HttpErrorException;

/**
 * This module handles Http Client resquest and response.
 */
final class Client
{
    const REQUEST_METHOD_GET = 'GET';

    const REQUEST_METHOD_HEAD = 'HEAD';

    const REQUEST_METHOD_POST = 'POST';

    const REQUEST_METHOD_PUT = 'PUT';

    const REQUEST_METHOD_DELETE = 'DELETE';

    const REQUEST_METHOD_CONNECT = 'CONNECT';

    const REQUEST_METHOD_OPTIONS = 'OPTIONS';

    const REQUEST_METHOD_PATCH = 'PATCH';

    /**
     * Make a cURL request.
     *
     * @param  array<string, string>  $payload
     * @param  array<string, string>  $headers
     */
    public function request(string $method, string $url, array $payload = [], array $headers = []): Response
    {
        $curl = curl_init();
        $method = strtoupper($method);

        if ($method === self::REQUEST_METHOD_GET && count($payload)) {
            $url = $url.'?'.http_build_query($payload);
        }

        if (in_array($method, [
            self::REQUEST_METHOD_POST,
            self::REQUEST_METHOD_PATCH,
            self::REQUEST_METHOD_PUT,
        ]) && count($payload)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => true,
        ]);

        $response = curl_exec($curl);

        if ($response === false || is_bool($response)) {
            throw new HttpErrorException(
                sprintf('cURL error %s: %s', curl_errno($curl), curl_error($curl))
            );
        }

        $response = Response::make(
            code: curl_getinfo($curl, CURLINFO_HTTP_CODE),
            header: substr($response, 0, $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE)),
            body: substr($response, $headerSize)
        );

        curl_close($curl);
        unset($curl);

        return $response;
    }
}
