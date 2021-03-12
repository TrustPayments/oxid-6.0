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


namespace Tru\TrustPayments\Extend\Application\Controller\Admin;

use Tru\TrustPayments\Application\Controller\Cron;

/**
 * Class BasketItem.
 * Extends \OxidEsales\Eshop\Application\Controller\Admin\LoginController.
 *
 * @mixin \OxidEsales\Eshop\Application\Controller\Admin\LoginController
 */
class LoginController extends LoginController_parent
{
    public function render()
    {
        $this->_aViewData['truCronUrl'] = Cron::getCronUrl();
        return $this->_NavigationController_render_parent();
    }

    protected function _NavigationController_render_parent()
    {
        return parent::render();
    }
}

