<?php
/**
 * TrustPayments OXID
 *
 * This OXID module enables to process payments with TrustPayments (https://www.trustpayments.com//).
 *
 * @package Whitelabelshortcut\TrustPayments
 * @author customweb GmbH (http://www.customweb.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0  Apache Software License (ASL 2.0)
 */


namespace Tru\TrustPayments\Extend\Application\Controller;

use Tru\TrustPayments\Application\Controller\Cron;


/**
 * Class used to include tracking device id on basket.
 *
 * Class BasketController.
 * Extends \OxidEsales\Eshop\Application\Controller\StartController.
 *
 * @mixin \OxidEsales\Eshop\Application\Controller\StartController
 */
class StartController extends StartController_parent
{
    public function render()
    {
        $this->_aViewData['truCronUrl'] = Cron::getCronUrl();
        return $this->_StartController_render_parent();
    }

    protected function _StartController_render_parent()
    {
        return parent::render();
    }
}