<?php

namespace WeDev\SimpleCrawler\Contracts;

use GuzzleHttp\Psr7\Response;

interface DownloaderInterface
{
  public function download(string $url, string $verb): Response;
}
