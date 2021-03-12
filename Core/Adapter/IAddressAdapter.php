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

namespace Tru\TrustPayments\Core\Adapter;

/**
 * Interface IAddressAdapter
 * Defines which methods must be implemented to be consumed with TrustPayments SDK.
 *
 * @codeCoverageIgnore
 */
interface IAddressAdapter {

	function getBillingAddressData();

	function getShippingAddressData();
}