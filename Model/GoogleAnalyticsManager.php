<?php
/**
 * This file is part of the PrestaGoogleAnalyticsDashboardBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\GoogleAnalyticsDashboardBundle\Model;

use Presta\GoogleAnalyticsDashboardBundle\Model\Response\Row;
use Widop\GoogleAnalytics\Client;
use Widop\GoogleAnalytics\Query;
use Widop\GoogleAnalytics\Response;
use Widop\GoogleAnalytics\Service;
use Widop\HttpAdapter\CurlHttpAdapter;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class GoogleAnalyticsManager
{
    /**
     * @var string
     */
    protected $profileId;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $privateKeyFile;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @param string $profileId
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param string $privateKeyFile
     */
    public function setPrivateKeyFile($privateKeyFile)
    {
        $this->privateKeyFile = $privateKeyFile;
    }

    /**
     * @return Query
     */
    protected function getQuery()
    {
        return new Query($this->profileId);
    }

    /**
     * @return Service
     */
    protected function getService()
    {
        if ($this->service == null) {
            $httpAdapter = new CurlHttpAdapter();
            $client = new Client($this->clientId, $this->privateKeyFile, $httpAdapter);

            $this->service = new Service($client);
        }

        return $this->service;
    }

    /**
     * Return base metrics for detailed queries
     *
     * @return array
     */
    protected function getMetrics()
    {
        return array(
            'ga:pageviews',
            'ga:pageviewsPerVisit',
            'ga:visits',
            'ga:newVisits',
            'ga:timeOnSite',
            'ga:avgTimeOnSite',
            'ga:visitBounceRate'
        );
    }

    /**
     * @return Row
     */
    public function getToday()
    {
        return $this->doQuery(array(
            'dimensions'    => array('ga:date'),
            'metrics'       => $this->getMetrics(),
            'start-date'    => date('Y-m-d'),
            'end-date'      => date('Y-m-d')
        ));
    }

    /**
     * @return Row
     */
    public function getYesterday()
    {
        return $this->doQuery(array(
            'dimensions'    => array('ga:date'),
            'metrics'       => $this->getMetrics(),
            'start-date'    => date('Y-m-d', strtotime('yesterday')),
            'end-date'      => date('Y-m-d', strtotime('yesterday'))
        ));
    }

    /**
     * @return Row
     */
    public function getLastMonth()
    {
        return $this->doQuery(array(
            'dimensions'    => array('ga:date'),
            'metrics'       => $this->getMetrics(),
            'start-date'    => date('Y-m-d', strtotime('31 days ago')),
            'end-date'      => date('Y-m-d', strtotime('yesterday'))
        ));
    }

    /**
     * @todo
     */
    public function getTopContent()
    {

    }

    /**
     * @todo
     */
    public function getTopReferrers()
    {

    }

    /**
     * Request google analytics
     *
     * @param  array $parameters
     * @param  bool  $multipleResults
     * @return array|mixed
     */
    protected function doQuery(array $parameters, $multipleResults = false)
    {
        $parameters += array(
            'dimensions' => array(),
            'metrics' => array(),
            'sort' =>  array(),
            'filters'=>array(),
            'start-date'=>null,
            'end-date'=> null,
            'start-index' => 1,
            'max-results' => 30,
            'prettyprint'=> 'true'
        );

        $query = $this->getQuery();
        $query->setStartDate(new \DateTime($parameters['start-date']));
        $query->setEndDate(new \DateTime($parameters['end-date']));

        $query->setMetrics($parameters['metrics']);
        $query->setDimensions($parameters['dimensions']);

        $query->setSorts($parameters['sort']);
        $query->setFilters($parameters['filters']);

        $query->setStartIndex($parameters['start-index']);
        $query->setMaxResults($parameters['max-results']);
        $query->setPrettyPrint($parameters['prettyprint']);
        $query->setCallback(null);

        $response = $this->getService()->query($query);

        $results = $this->formatResponse($response, array_merge($parameters['dimensions'], $parameters['metrics']));

        if ($multipleResults == false) {
            return array_shift($results);
        }

        return $results;
    }

    /**
     * @param  Response $response
     * @param  array $cols
     * @return array
     */
    protected function formatResponse(Response $response, array $cols)
    {
        $results = array();

        foreach ($response->getRows() as $row) {
            $results[] = new Row(array_combine($cols, $row));
        }

        return $results;
    }
}
