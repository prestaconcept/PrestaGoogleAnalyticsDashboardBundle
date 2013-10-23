<?php
/**
 * This file is part of the PrestaGoogleAnalyticsDashboardBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\GoogleAnalyticsDashboardBundle\Model\Response;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class Row
{
    /**
     * Raw data returned by google analytics
     *
     * @var array
     */
    protected $properties = array();

    public function __construct($properties)
    {
        $defaults = array(
            'ga:pageviews'          => 0,
            'ga:pageviewsPerVisit'  => 0,
            'ga:visits'             => 0,
            'ga:newVisits'          => 0,
            'ga:timeOnSite'         => 0,
            'ga:avgTimeOnSite'      => 0,
            'ga:visitBounceRate'    => 0,
        );
        $this->properties = $properties + $defaults;
    }

    /**
     * @return int
     */
    public function getVisits()
    {
        return $this->properties['ga:visits'];
    }

    /**
     * @return int
     */
    public function getNewVisits()
    {
        return $this->properties['ga:newVisits'];
    }

    /**
     * @return int
     */
    public function getPageViews()
    {
        return $this->properties['ga:pageviews'];
    }

    /**
     * @return float
     */
    public function getPageViewsPerVisit()
    {
        return round($this->properties['ga:pageviewsPerVisit'], 2);
    }

    /**
     * @return string
     */
    public function getAvgTimeOnSite()
    {
        $seconds = $this->properties['ga:avgTimeOnSite'];

        $hours   = floor($seconds / (60 * 60));
        $minutes = floor(($seconds - ($hours * 60 * 60)) / 60);
        $seconds = $seconds - ($minutes * 60) - ($hours * 60 * 60);

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    /**
     * @return float
     */
    public function getVisitBounceRate()
    {
        return round($this->properties['ga:visitBounceRate'], 2);
    }
}
