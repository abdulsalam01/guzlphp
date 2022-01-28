<?php
    require 'vendor/autoload.php';

    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;
    use GuzzleHttp\Psr7;
    use GuzzleHttp\Exception\ClientException;

    class Requests {
        function headers($header = []) {
            return array_merge(['Content-Type' => 'application/json'], $header);
        }

        function body($data) {
            return $data;
        }

        function sendRequest() {
            $body = $this->body(['input' => 'hello, world!']);
            $headers = $this->headers();
            $promise = null;

            try {
                $client = new Client(['base_uri' => 'https://yourapidomain.com/api']);
                $request = new Request('POST', '/order', $headers, json_encode($body));
                // send-it
                $promise = $client->send($request);
            } catch (ClientException $e) {
                return Psr7\Message::toString($e->getResponse());
            }

            return $promise;
        }
    }

    $r = new Requests();
    echo json_encode($r->sendRequest());
?>