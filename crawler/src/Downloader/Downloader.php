<?php

namespace WeDev\SimpleCrawler\Downloader;

use WeDev\SimpleCrawler\Contracts\DownloaderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class Downloader implements DownloaderInterface
{
  public function download(string $verb, string $url): Response
  {
    $client = new Client();

    return $client->request($verb, $url);
  }
}
