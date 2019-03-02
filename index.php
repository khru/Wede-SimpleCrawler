<?php

declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

use WeDev\SimpleCrawler\Config;
use WeDev\SimpleCrawler\Drivers\AxesorDriver;
use WeDev\SimpleCrawler\Parser\HtmlParser;

$config = new Config();
//echo $config->get('axesorUrl');
$a = new AxesorDriver();
$parser = new HtmlParser();
$a->crawl($config, $parser);
