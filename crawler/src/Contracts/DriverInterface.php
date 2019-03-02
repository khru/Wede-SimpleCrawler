<?php

namespace WeDev\SimpleCrawler\Contracts;

use WeDev\SimpleCrawler\Config;

interface DriverInterface
{
  public function crawl(Config $config, ParserInterface $parser);
}
