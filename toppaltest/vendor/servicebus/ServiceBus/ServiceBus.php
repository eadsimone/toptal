<?php

namespace ServiceBus;

/**
 * Class ServiceBus.
 * Used for the comunication with Service Bus.
 *
 * @author Daniel David Duarte <danielddu@hotmail.com>
 */
class ServiceBus {

    /**
     * Returns the list of all container for a specific client, in the form:
     *
     *   array(
     *       '5216' => 'Container 1',
     *       '126'  => 'Container 2'
     *   );
     *
     * Where the keys of the array are the IDs of the players, and the values
     * are their names.
     *
     * @return array
     */
    public function getAllContainers()
    {
        $url = $this->getServiceBusAllContainersUrl($this->getCurrentClientId());

        $httpClient = new \ServiceBus\HttpClient();
        $result = $httpClient->get($url);
        $decodedResult = json_decode($result);

        $responseObject = $decodedResult->responseObject;

        $containers = array();
        foreach ($responseObject as $container) {
            $containers[$container->id] = $container->name;
        }

        return   $containers;
    }

    /**
     * Returns the analytics statistics according to the parameters.
     *
     * @param string $datasetName The name of the requested dataset, that is one
     *     of the tab names of the frontend: 'summary', 'attract', 'interact' or
     *     'transact'.
     * @param array|null $playerCodes An array of integers representing the
     *     player codes to get the statistical data for. Pass null to get the
     *     statistics for all the players of the client.
     * @param string $dateFrom The date from in string format.
     * @param string $dateTo The date to in string format.
     *
     * @return string The statistics data organized in sections, as a JSON
     *     object.
     */
    public function getAnalyticsData($datasetName, $playerCodes, $dateFrom, $dateTo)
    {
         $chartCodesByTabName = array(
            'summary' => array(
                "playerPerformanceSummary",
                "topContainerHostedSites",
                "topPlayerViewsByState",
                "playerPerformanceSummaryRatios",
                "playerConversionsByProductType"
            ),
            'attract' => array(
                "playerAttractSummary",
                "playerAttractVisitorSummary",
                "topPlayerViewsByState",
                "containerAttractSummaryViewsRatio",
                "playerBrowserSummary",
                "playerOperatingSystemSummary"
            ),
            'interact' => array(
                "playerInteractSummary",
                "playerTopSocialSites",
                "topPlayerSharesByState",
                "playerInteractSummaryViewsRatio",
                "playerPerformanceSummaryDirect",
                "playerPerformanceSummaryViral"
            ),
            'transact' => array(
                "containerTransactSummary",
                "containerTakeActionsLeadSummary",
                "containerRevenueByState",
                "containerRevenueSummaryRatios",
                "containerTransactSummaryDirect",
                "containerTransactSummaryViral",
                "containerTransactBreakoutSummary"
            )
        );

        if (array_key_exists($datasetName, $chartCodesByTabName)) {
            $chartCodesToRequest = $chartCodesByTabName[$datasetName];
        } else {
            $chartCodesToRequest = array();
        }

        return $this->requestStats($chartCodesToRequest, $this->parsePlayerCodes($playerCodes), $dateFrom, $dateTo, true);
    }

    /**
     * Return the currently configured Service Bus URL for statistics data.
     *
     * @return string The URL for SB stats.
     */
    public function getServiceBusStatsUrl($urlForEncryptedService = false) {
        return $this->getServiceBusBaseUrl($urlForEncryptedService) . 'stats';
    }

    public function getServiceBusAllContainersUrl($clientId, $urlForEncryptedService = false) {
        return $this->getServiceBusBaseUrl($urlForEncryptedService) . 'lsbPlayerService/getAllPlayers/' . $clientId;
    }

    public function getServiceBusBaseUrl($urlForEncryptedService = false) {
        if ($urlForEncryptedService) {
            $url = getenv('CINSAY_SERVICE_BUS_ANALYTICS_URL');
        } else {
            $url = getenv('CINSAY_SERVICE_BUS_URL');
        }

        return $url;
    }

    /**
     * Returns the public Service Bus API key needed to make requests.
     * This value is configured in the .htaccess file, with the variable name
     * CINSAY_SERVICE_BUS_PUBLIC_API_KEY.
     *
     * @return string The public API key.
     */
    public function getServiceBusPublicApiKey() {
        return getenv('CINSAY_SERVICE_BUS_PUBLIC_API_KEY');
    }

    /**
     * Returns the private Service Bus API key needed to make requests with
     * encoding.
     * This value is configured in the .htaccess file, with the variable name
     * CINSAY_SERVICE_BUS_PRIVATE_API_KEY.
     *
     * @return string The private API key.
     */
    public function getServiceBusPrivateApiKey() {
        return getenv('CINSAY_SERVICE_BUS_PRIVATE_API_KEY');
    }

    public function getCurrentClientId() {
        return getenv('CINSAY_CLIENT_ID');
    }

    /**
     * Returns the list of players to request analytics data for
     *
     * @return array of int, or null to specify all the players.
     */
    private function parsePlayerCodes($commaSeparatedPlayerCodes) {
        if (empty($commaSeparatedPlayerCodes) || strtolower(trim($commaSeparatedPlayerCodes)) === 'all') {
            $codes = null;
        } else {
            $codes = explode(',', $commaSeparatedPlayerCodes);
            $codes = array_map(function ($code) {
                return intval($code);
            }, $codes);
        }

        return $codes;
    }

    /**
     * Requests the Service Bus to get the analytics data, according to the
     * specified parameters.
     *
     * @param array $chartCodes The list of chart codes to retrieve data for.
     * @param string $playerCodes A comma separated list of player IDs, or 'all'
     *     to get the data for all the players of the corresponding client.
     * @param string $dateFrom The initial date for the statistics requested.
     * @param string $dateTo The final date for the statistics requested.
     * @param boolean $returnJson Flag to indicate if the result will be
     *   retorned as JSON (if true, default) of as a PHP structure (if false).
     *
     * @return mixed The analytics data in JSON format (string) or PHP StdClass.
     *   See $chartCodes param documentation bellow.
     */
    private function requestStats($chartCodes, $playerCodes, $dateFrom, $dateTo, $useEncoding = true, $returnJson = true)
    {
        $clientId = $this->getCurrentClientId();

        $requestObject = array(
            'clientId'  => $clientId,
            'storeId'   => null,
            'playerIds' => $playerCodes,
            'startDate' => $dateFrom,
            'stopDate'  => $dateTo,
            'statList'  => $chartCodes,
            'typeName'  => 'stats_request'
        );

        $request = array(
            'requestObject' => $requestObject,
            'params'   => null,
            'clientId' => $clientId,
            'apiKey'   => $this->getServiceBusPublicApiKey()
        );

        // Prepare service call parameters
        $postData = json_encode($request);
        if ($useEncoding) {
            $postData = base64_encode($postData) . '.' . md5($this->getServiceBusPrivateApiKey() . base64_encode($postData));
            $serviceUrl = $this->getServiceBusStatsUrl(true);
        } else {
            $serviceUrl = $this->getServiceBusStatsUrl(false);
        }

        $httpClient = new \ServiceBus\HttpClient();
        $response = $httpClient->post($serviceUrl, $postData);

        return $returnJson ? $response : json_decode($response);
    }
}