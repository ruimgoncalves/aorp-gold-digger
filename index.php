<?php

//curl -X GET http://www.aorp.pt/quotessearch.php?date=2017-01-12

namespace GoldDigger;

/**
 *
 */
class Aorp
{
    private $requestDate;
    private $date;
    private $silver;
    private $gold;

    function __construct($dateStr = NULL)
    {
        $this->requestDate = empty($dateStr) ? date("Y-m-d") : $dateStr;

        $html = file_get_contents("http://www.aorp.pt/quotessearch.php?date=$this->requestDate");
        if(empty($html)){
            throw new \Exception("Site não respondeu", 1);
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(TRUE); //disable libxml errors
        $doc->loadHTML($html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($doc);

        $nodeDataArr   = $xpath->query('//li/div[@class="quotesColumn1"]');
        $nodeGoldArr   = $xpath->query('//li/div[@class="quotesColumn2"]');
        $nodeSilverArr = $xpath->query('//li/div[@class="quotesColumn3"]');

        if (!$nodeDataArr){
            throw new \Exception("Resposta inesperada, atualize o script!", 2);
        }

        $this->date   = $nodeDataArr->item(1)->nodeValue;
        $this->silver = (float) $nodeSilverArr->item(1)->nodeValue;
        $this->gold   = (float) $nodeGoldArr->item(1)->nodeValue;
    }

    public function getDate(){
        return empty($this->date) ? $this->requestDate : $this->date;
    }

    public function hasQuote(){
        return $this->gold > 0;
    }

    public function getGoldQuote($karats = 24){
        return $this->gold * ($karats / 24);
    }

    public function getSilverQuote(){
        return $this->silver;
    }

}

?>
