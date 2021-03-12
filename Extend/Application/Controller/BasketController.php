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

use Tru\TrustPayments\Core\TrustPaymentsModule;

/**
 * Class used to include tracking device id on basket.
 *
 * Class BasketController.
 * Extends \OxidEsales\Eshop\Application\Controller\BasketController.
 *
 * @mixin \OxidEsales\Eshop\Application\Controller\BasketController
 */
class BasketController extends BasketController_parent
{
    public function render()
    {
        parent::render();

        $this->setTrustPaymentsDeviceCookie();
        $this->_aViewData['TrustPaymentsDeviceScript'] = $this->getTrustPaymentsDeviceUrl();

        return 'truTrustPaymentsCheckoutBasket.tpl';
    }

    private function getTrustPaymentsDeviceUrl()
    {
        $script = TrustPaymentsModule::settings()->getBaseUrl();
        $script .= '/s/[spaceId]/payment/device.js?sessionIdentifier=[UniqueSessionIdentifier]';

        $script = str_replace(array(
            '[spaceId]',
            '[UniqueSessionIdentifier]'
        ), array(
            TrustPaymentsModule::settings()->getSpaceId(),
            $_COOKIE['TrustPayments_device_id']
        ), $script);

        return $script;
    }

    private function setTrustPaymentsDeviceCookie()
    {
        if (isset($_COOKIE['TrustPayments_device_id'])) {
            $value = $_COOKIE['TrustPayments_device_id'];
        } else {
        	$_COOKIE['TrustPayments_device_id'] = $value = TrustPaymentsModule::getUtilsObject()->generateUId();
        }
        setcookie('TrustPayments_device_id', $value, time() + 365 * 24 * 60 * 60, '/');
    }
}