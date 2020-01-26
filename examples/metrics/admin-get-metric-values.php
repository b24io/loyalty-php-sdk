<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use \Monolog\Logger;
use \B24io\Loyalty\SDK;
use \B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Ramsey\Uuid\Uuid;

$argv = getopt('', ['clientApiKey::', 'authApiKey::', 'apiEndpoint::', 'dateFrom::', 'dateTo::']);
$fileName = basename(__FILE__);

$clientApiKey = $argv['clientApiKey'];
if ($clientApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «clientApiKey»  not found') . PHP_EOL);
}
$authApiKey = $argv['authApiKey'];
if ($authApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «authApiKey»  not found') . PHP_EOL);
}
$apiEndpoint = $argv['apiEndpoint'];
if ($apiEndpoint === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «apiEndpoint»  not found') . PHP_EOL);
}
$dateFrom = new \DateTime($argv['dateFrom']);
$dateTo = new \DateTime($argv['dateTo']);


// check connection to API
$log = new Logger('loyalty-php-sdk');
$log->pushHandler(new \Monolog\Handler\StreamHandler('loyalty-php-sdk-example.log', Logger::DEBUG));
$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(
    Middleware::log(
        $log,
        new MessageFormatter(MessageFormatter::SHORT)
    )
);
$httpClient = new \GuzzleHttp\Client();
$log->info('loyalty.apiClient.start');
$token = new SDK\Auth\DTO\Token(
    SDK\Transport\DTO\Role::initializeByCode('admin'),
    Uuid::fromString($clientApiKey),
    Uuid::fromString($authApiKey)
);
$apiClient = new SDK\ApiClient($apiEndpoint, $token, $httpClient, $log);
$apiClient->setGuzzleHandlerStack($guzzleHandlerStack);

// connect to application and read settings
$metricTransport = SDK\Metrics\Transport\Admin\Fabric::getMetricTransport($apiClient, $log);
$decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());
try {
    $metricResponse = $metricTransport->getMetricCollection();
    foreach ($metricResponse->getMetricCollection() as $metric) {
        print(sprintf(
                '%s - | %s | %s',
                $metric->getCode()->getValue(),
                $metric->getType()->key(),
                $metric->getName()
            ) . PHP_EOL);
        print(sprintf('%s', $metric->getDescription()) . PHP_EOL);

        // get metric values
        $reportResponse = $metricTransport->getReportByMetricCode($metric->getCode(), $dateFrom, $dateTo);
        foreach ($reportResponse->getReport()->getValues() as $cnt => $value) {
            /**
             * @var SDK\Metrics\DTO\Values\AbstractValue $value
             */
            switch ($reportResponse->getReport()->getMetric()->getType()) {
                case SDK\Metrics\DTO\MetricType::FLOAT():
                case SDK\Metrics\DTO\MetricType::INTEGER():
                    print(sprintf(
                            '     %s | %s  | %s',
                            $cnt,
                            $value->getTimestamp()->format(\DATE_ATOM),
                            $value->getValue()
                        ) . PHP_EOL);
                    break;
                case SDK\Metrics\DTO\MetricType::MONEY():
                    /**
                     * @var SDK\Metrics\DTO\Values\MoneyValue $value
                     */
                    print(sprintf(
                            '     %s | %s | %s',
                            $cnt,
                            $value->getTimestamp()->format(\DATE_ATOM),
                            $decimalMoneyFormatter->format($value->getValue())
                        ) . PHP_EOL);
                    break;
                case SDK\Metrics\DTO\MetricType::PERCENTAGE():
                    /**
                     * @var SDK\Metrics\DTO\Values\PercentageValue $value
                     */
                    print(sprintf(
                            '     %s | %s | %s',
                            $cnt,
                            $value->getTimestamp()->format(\DATE_ATOM),
                            $value->getValue()->format()
                        ) . PHP_EOL);
                    break;
            }
        }
        print('-----------' . PHP_EOL);
    }
} catch (SDK\Exceptions\ApiClientException $exception) {
    var_dump($exception->getApiProblem()->asArray());
}