<?php

use Clue\React\Buzz\Browser;
use Clue\React\Soap\Client;
use Clue\React\Soap\Proxy;

require __DIR__ . '/../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$browser = new Browser($loop);

$blz = isset($argv[1]) ? $argv[1] : '12070000';

$client = new Client($browser, null, array(
    'location' => 'http://www.thomas-bayer.com/axis2/services/BLZService',
    'uri' => 'http://thomas-bayer.com/blz/',
    'use' => SOAP_LITERAL
));
$api = new Proxy($client);

$api->getBank(new SoapVar($blz, XSD_STRING, null, null, 'blz', 'http://thomas-bayer.com/blz/'))->then(
    function ($result) {
        echo 'SUCCESS!' . PHP_EOL;
        var_dump($result);
    },
    function (Exception $e) {
        echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    }
);

$loop->run();
