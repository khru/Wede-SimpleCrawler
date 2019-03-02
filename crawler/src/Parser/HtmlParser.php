<?php

namespace WeDev\SimpleCrawler\Parser;

use WeDev\SimpleCrawler\Contracts\ParserInterface;

class HtmlParser implements ParserInterface
{
  public function parse(string $html, string $xpathQuery): \Iterator
  {
    $xml = new \DOMDocument($html);
    $xml->loadHTML($html);
    $xpath = new \DOMXpath($xml);

    foreach ($xpath->evaluate($xpathQuery) as $node) {
      yield $node->value;
    }
  }
}
