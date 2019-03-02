<?php

namespace WeDev\SimpleCrawler\Drivers;

use WeDev\SimpleCrawler\Contracts\DriverInterface as DriverInterface;
use WeDev\SimpleCrawler\Config;
use WeDev\SimpleCrawler\Downloader\Downloader;
use WeDev\SimpleCrawler\Contracts\ParserInterface;
use Illuminate\Support\Collection;

/**
 * This class will be the wrapper class to crawl axesor.
 */
class AxesorDriver implements DriverInterface
{
  private $finalUrls;
  private $companiesData = [];
  private $downloader;
  private $baseUrl;
  private $parser;
  private const XPATH_QUERIES = [
        'provinces' => "//*[@id='bloque_listadoProvincias']//a/@href",
        'towns' => "//*[@id = 'bloque_listadoMunicipios']//a/@href",
    ];
  private const REGEX = [
        'provinces' => '/[A-Z].*$/m',
        'towns' => '/(informacion-empresas-de-)([A-Z].*)\//m',
    ];

  public function crawl(Config $config, ParserInterface $parser)
  {
    $this->config = $config;
    $this->downloader = new Downloader();
    $this->baseUrl = $this->config->get('axesorUrl');
    $this->parser = $parser;
    $provinces = $this->curlProvinces($this);

    $result = $provinces->map(function ($province) {
      $province['towns'] = $this->getTowns($this, $province['url'])->toArray();

      return $province;
    });
    echo $result->toJson();
  }

  private function curlProvinces(AxesorDriver $axesor,
                                string $xpath = self::XPATH_QUERIES['provinces']): Collection
  {
    $buffer = new Collection();
    $response = $axesor->downloader->download('GET', $axesor->baseUrl);

    foreach ($axesor->parser->parse($response->getBody()->getContents(), $xpath) as $key => $value) {
      $value = (!is_null($value) && false !== strpos($value, '//')) ? str_replace('//', '', $value) : $value;
      preg_match(self::REGEX['provinces'], $value, $province);
      $item['province'] = $province[0];
      $item['url'] = $value;
      $buffer->push($item);
    }

    return $buffer;
  }

  private function getTowns(AxesorDriver $axesor, string $url,
                        string $xpath = self::XPATH_QUERIES['towns']): Collection
  {
    $buffer = new Collection();
    $response = $axesor->downloader->download('GET', $url);

    foreach ($axesor->parser->parse($response->getBody()->getContents(), $xpath) as $key => $value) {
      $value = (!is_null($value) && false !== strpos($value, '//')) ? str_replace('//', '', $value) : $value;
      preg_match(self::REGEX['towns'], $value, $towns);
      $item['town'] = $towns[2];
      $item['url'] = $value;
      $buffer->push($item);
    }

    return $buffer;
  }
}
