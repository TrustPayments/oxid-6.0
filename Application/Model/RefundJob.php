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

namespace Tru\TrustPayments\Application\Model;

use Tru\TrustPayments\Core\Service\JobService;
use Tru\TrustPayments\Core\Service\RefundService;

/**
 * Class RefundJob.
 * RefundJob model.
 */
class RefundJob extends AbstractJob
{
    private $formReductions;

    public function getRestock() {
        return $this->getFieldData('trurestock');
    }

    public function setRestock($value){
        $this->_setFieldData('trurestock', $value);
    }

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('truTrustPayments_refundjob');
    }

    public function setFormReductions(array $formReductions)
    {
        $this->formReductions = $formReductions;
    }
    public function getFormReductions(){
        return $this->formReductions;
    }

    /**
     * @return JobService
     */
    protected function getService()
    {
        return RefundService::instance();
    }
}