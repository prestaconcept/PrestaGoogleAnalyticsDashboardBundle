<?php
/**
 * This file is part of the PrestaGoogleAnalyticsDashboardBundle.
 *
 * (c) PrestaConcept <http://www.prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Presta\GoogleAnalyticsDashboardBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class DashboardBlockService extends BaseBlockService
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'GoogleAnalyticsDashboard';
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = array_merge($this->getDefaultSettings(), $blockContext->getSettings());

        return $this->renderResponse(
            'PrestaGoogleAnalyticsDashboardBundle:Block:block_dashboard.html.twig',
            array(
                'block_context'  => $blockContext,
                'block'     => $blockContext->getBlock(),
                'blockId'   => 'block-google-analytics-dashboard',
                'settings'  => $settings
            ),
            $response
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSettings()
    {
        return array();
    }
}
