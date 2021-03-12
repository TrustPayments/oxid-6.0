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

use Monolog\Logger;
use TrustPayments\Sdk\Model\TransactionState;
use Tru\TrustPayments\Application\Model\Transaction;
use Tru\TrustPayments\Core\Service\TransactionService;
use Tru\TrustPayments\Core\TrustPaymentsModule;

/**
 * Class BasketItem.
 * Extends \OxidEsales\Eshop\Application\Controller\OrderController.
 *
 * @mixin \OxidEsales\Eshop\Application\Controller\OrderController
 */
class OrderController extends OrderController_parent
{
    public function init()
    {
        $this->_OrderController_init_parent();
        if ($this->getIsOrderStep()) {
            try {
                $transaction = Transaction::loadPendingFromSession($this->getSession());
                $transaction->updateFromSession();
            } catch (\Exception $e) {
                TrustPaymentsModule::log(Logger::ERROR, "Could not update transaction: {$e->getMessage()}.");
            }
        }
    }

    protected function _OrderController_init_parent()
    {
        parent::init();
    }

    public function truConfirm()
    {
    	\OxidEsales\Eshop\Core\DatabaseProvider::getDb()->startTransaction();
    	$order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
        $response = array(
            'status' => false,
            'message' => 'unkown'
        );

        if ($this->isTrustPaymentsTransaction()) {
        	if($this->_validateTermsAndConditions()) {
	            try {
	                $transaction = Transaction::loadPendingFromSession($this->getSession());
	                /* @var $order \Tru\TrustPayments\Extend\Application\Model\Order */
	                /** @noinspection PhpParamsInspection */
	                $order->setConfirming(true);
	                $state = $order->finalizeOrder($this->getBasket(), $this->getUser());
	                $order->setConfirming(false);
	                if ($state === 'TRUSTPAYMENTS_' . TransactionState::PENDING) {
	                    $transaction->setTempBasket($this->getBasket());
	                    $transaction->setOrderId($order->getId());
	                    \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->commitTransaction();
	                    \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->startTransaction();
	                    $transaction->updateFromSession(true);
	                    \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->commitTransaction();
	                    $response['status'] = true;
	                } else if ($state == \OxidEsales\Eshop\Application\Model\Order::ORDER_STATE_ORDEREXISTS) {
	                    // ensure new order can be created
	                    $this->getSession()->deleteVariable('sess_challenge');
	                    throw new \Exception(TrustPaymentsModule::instance()->translate("Order already exists. Please check if you have already received a confirmation, then try again."));
	                } else {
	                    throw new \Exception(TrustPaymentsModule::instance()->translate("Unable to confirm order in state !state.", true, array('!state' => $state)));
	                }
	            } catch (\Exception $e) {
	                if (isset($transaction)) {
	                    $state = $transaction->getState();
	                } else if (!isset($state)) {
	                    $state = 'confirmation_error_unkown';
	                }
	                $order->TrustPaymentsFail($e->getMessage(), $state, true);
	                TrustPaymentsModule::log(Logger::ERROR, "Unable to confirm transaction: {$e->getMessage()}.");
	                $response['message'] = $e->getMessage();
	            }
        	}
        	else {
        		$response['message'] = TrustPaymentsModule::instance()->translate("You must agree to the terms and conditions.");
        	}
        } else {
            $response['message'] = TrustPaymentsModule::instance()->translate("Not a Trust Payments order.");
        }

        TrustPaymentsModule::renderJson($response);
    }

    public function truError()
    {
        try {
            $orderId = TrustPaymentsModule::instance()->getRequestParameter('oxid');
            if ($orderId) {
            	$order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
                /* @var $order Order */
            	$transaction = oxNew(\Tru\TrustPayments\Application\Model\Transaction::class);
                /* @var $transaction Transaction */
                if ($order->load($orderId) && $transaction->loadByOrder($orderId)) {
                    $transaction->pull();
                    $order->TrustPaymentsFail($transaction->getSdkTransaction()->getUserFailureMessage(), $transaction->getState());
                    TrustPaymentsModule::getUtilsView()->addErrorToDisplay($transaction->getSdkTransaction()->getUserFailureMessage());
                } else {
                	TrustPaymentsModule::getUtilsView()->addErrorToDisplay(TrustPaymentsModule::instance()->translate("An unknown error occurred, and the order could not be loaded."));
                }
            } else {
                $transaction = Transaction::loadFailedFromSession($this->getSession());
                if ($transaction) {
                    if ($transaction->getOrderId()) {
                    	$order = oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
                        /* @var $order \OxidEsales\Eshop\Application\Model\Order */
                        if ($order->load($transaction->getOrderId())) {
                            $order->TrustPaymentsFail($transaction->getSdkTransaction()->getUserFailureMessage(), $transaction->getState());
                        }
                    }
                    TrustPaymentsModule::getUtilsView()->addErrorToDisplay($transaction->getSdkTransaction()->getUserFailureMessage());
                } else {
                	TrustPaymentsModule::getUtilsView()->addErrorToDisplay(TrustPaymentsModule::instance()->translate("An unknown error occurred, and the order could not be loaded."));
                }
            }
        } catch (\Exception $e) {
        	TrustPaymentsModule::getUtilsView()->addErrorToDisplay($e);
        }
    }
    
    public function isTrustPaymentsTransaction()
    {
        return TrustPaymentsModule::isTrustPaymentsPayment($this->getBasket()->getPaymentId());
    }

    public function getTrustPaymentsPaymentId()
    {
        return TrustPaymentsModule::extractTrustPaymentsId($this->getBasket()->getPaymentId());
    }

    public function getTrustPaymentsJavascriptUrl()
    {
        try {
            $transaction = Transaction::loadPendingFromSession($this->getSession());
            return TransactionService::instance()->getJavascriptUrl($transaction->getTransactionId(), $transaction->getSpaceId());
        } catch (\Exception $e) {
            TrustPaymentsModule::log(Logger::ERROR, $e->getMessage(), array($this, $e));
        }
        return '';
    }
}