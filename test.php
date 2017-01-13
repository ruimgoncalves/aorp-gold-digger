<?php

require_once('index.php');

try {
    $aorp = new \GoldDigger\Aorp();
    $date = $aorp->getDate();

    if ($aorp->hasQuote()){
        $silver = $aorp->getSilverQuote();
        $gold = $aorp->getGoldQuote();
        $gold192k = $aorp->getGoldQuote(19.2);
        $gold9k   = $aorp->getGoldQuote(9);
        echo "Valor de referência para $date\n";
        echo "Prata = $silver\n";
        echo "Ouro = $gold\n\t19.2k = $gold192k\n\t9k = $gold9k";
    } else {
        echo "Sem valor de cotação para o dia $date!!";
    }

} catch (Exception $e){
    echo "Erro : " . $e->getMessage();
}
