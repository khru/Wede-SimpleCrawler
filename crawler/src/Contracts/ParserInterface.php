<?php

namespace WeDev\SimpleCrawler\Contracts;

interface ParserInterface
{
  public function parse(string $input, string $xpathQuery): \Iterator;
}
