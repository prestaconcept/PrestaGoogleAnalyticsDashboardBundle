<?php
/**
 * This file is part of the PrestaGoogleAnalyticsDashboardBundle
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Presta\GoogleAnalyticsDashboardBundle\Tests\Mock;

use Presta\GoogleAnalyticsDashboardBundle\Model\GoogleAnalyticsManager;
use Presta\GoogleAnalyticsDashboardBundle\Model\Response\Row;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class GoogleAnalyticsManagerMock extends GoogleAnalyticsManager
{
    /**
     * {@inheritdoc}
     */
    public function isDummy()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getToday()
    {
        return new Row(
            array(
                'ga:date'               =>  '20131031',
                'ga:pageviews'          =>  '334',
                'ga:pageviewsPerVisit'  =>  '2.357142857142857',
                'ga:visits'             =>  '14' ,
                'ga:newVisits'          =>  '10' ,
                'ga:timeOnSite'         =>  '2217.0' ,
                'ga:avgTimeOnSite'      =>  '158.35714285714286' ,
                'ga:visitBounceRate'    =>  '57.14285714285714' ,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getYesterday()
    {
        return new Row(
            array(
                'ga:date'               =>  '20131030',
                'ga:pageviews'          =>  '112',
                'ga:pageviewsPerVisit'  =>  '7.0',
                'ga:visits'             =>  '16' ,
                'ga:newVisits'          =>  '6' ,
                'ga:timeOnSite'         =>  '10590.0' ,
                'ga:avgTimeOnSite'      =>  '661.875' ,
                'ga:visitBounceRate'    =>  '37.5' ,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getLastMonth()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getTopContent()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getTopReferrers()
    {
        return array();
    }
}
