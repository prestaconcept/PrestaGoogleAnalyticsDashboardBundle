<?php
/**
 * This file is part of the PrestaGoogleAnalyticsDashboardBundle
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Presta\GoogleAnalyticsDashboardBundle\Controller\Admin;

use Presta\GoogleAnalyticsDashboardBundle\Model\GoogleAnalyticsManager;
use Presta\GoogleAnalyticsDashboardBundle\Controller\Admin\BaseController as AdminController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class DefaultController extends AdminController
{
    /**
     * @return GoogleAnalyticsManager
     */
    protected function getManager()
    {
        $manager = $this->get('presta_google_analytics_dashboard.manager.google_analytics');

        if ($manager->isDummy()) {
            return $this->get('presta_google_analytics_dashboard.manager.google_analytics.mock');
        }

        return $manager;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $manager    = $this->getManager();
        $today      = $manager->getToday();
        $yesterday  = $manager->getYesterday();

        $viewParams = array(
            'is_dummy' => $manager->isDummy(),

            'today_visit'               => $today->getVisits(),
            'today_page_view'           => $today->getPageViews(),
            'today_page_per_visit'      => $today->getPageViewsPerVisit(),
            'today_avg_time_on_site'    => $today->getAvgTimeOnSite(),
            'today_visit_bounce_rate'   => $today->getVisitBounceRate(),
            'today_new_visit'           => $today->getNewVisits(),

            'yesterday_visit'               => $yesterday->getVisits(),
            'yesterday_page_view'           => $yesterday->getPageViews(),
            'yesterday_page_per_visit'      => $yesterday->getPageViewsPerVisit(),
            'yesterday_avg_time_on_site'    => $yesterday->getAvgTimeOnSite(),
            'yesterday_visit_bounce_rate'   => $yesterday->getVisitBounceRate(),
            'yesterday_new_visit'           => $yesterday->getNewVisits(),
        );

        return $this->renderResponse('PrestaGoogleAnalyticsDashboardBundle:Admin/Default:index.html.twig', $viewParams);
    }
}
