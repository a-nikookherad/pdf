<?php

namespace PDF\Logics;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use PDF\Contracts\PDFLogicInterface;
use Psr\Http\Message\ResponseInterface;

class PDFLogic implements PDFLogicInterface
{
    private $client;
    private $html;
    private $clientConfig = [];

    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('PDF_SERVICE_URL')]);
    }

    public function setHtml(?string $html): self
    {
        $this->html = $html;

        return $this;
    }

    public function render()
    {
        $this->setConfig([
            RequestOptions::MULTIPART => [
                [
                    'name' => 'file',
                    'contents' => $this->getHtmlAsResource(),
                ]
            ]
        ]);

        $response = $this->request();

        return $response->getBody();
    }

    public function download(string $path, string $pdfName)
    {
        //make directory if not exists
        if (!file_exists($path)) {
            mkdir($path, 0666, true);
        }

        $path = rtrim($path, "/") . DIRECTORY_SEPARATOR . $pdfName . ".pdf";
        $fileResource = fopen($path, 'w+');

        $this->setConfig([
            RequestOptions::MULTIPART => [
                [
                    'name' => 'file',
                    'contents' => $this->getHtmlAsResource(),
                ]
            ],
            RequestOptions::SINK => $fileResource
        ]);

        $this->request();
    }

    private function request(): ResponseInterface
    {
        try {
            return $this->client->post(
                '/convert?auth=' . env('PDF_SERVICE_AUTH'),
                $this->clientConfig
            );

        } catch (ClientException $e) {
            \Log::error($e->getMessage());
            throw($e);
        } catch (RequestException $e) {
            \Log::error($e->getMessage());
            throw($e);
        }
    }

    public function setConfig(?array $config): self
    {
        $this->clientConfig = array_merge($config, $this->clientConfig);

        return $this;
    }

    private function getHtmlAsResource()
    {
        $resource = tmpfile();
        fwrite($resource, $this->html);
        rewind($resource);

        return $resource;
    }
}
