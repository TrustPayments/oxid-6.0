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

use Tru\TrustPayments\Extend\Application\Model\Order;

/**
 * Class NavigationController.
 * Extends \OxidEsales\Eshop\Application\Controller\Admin\OrderList.
 *
 * @mixin \OxidEsales\Eshop\Application\Controller\Admin\OrderList
 */
class OrderList extends OrderList_parent
{
    protected $_sThisTemplate = 'truTrustPaymentsOrderList.tpl';

    public function render()
    {
        $orderId = $this->getEditObjectId();
        if ($orderId != '-1' && isset($orderId)) {
        	$order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
            $order->load($orderId);
            /* @var $order Order */

            if ($order->isTruOrder()) {
                $this->_aViewData['truEnabled'] = true;
            }
        }
        $this->_OrderList_render_parent();

        return $this->_sThisTemplate;
    }

    protected function _OrderList_render_parent()
    {
        return parent::render();
    }
}