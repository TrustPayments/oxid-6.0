<?php
/**
 * TrustPayments OXID
 *
 * This OXID module enables to process payments with TrustPayments (https://www.trustpayments.com//).
 *
 * @package Whitelabelshortcut\TrustPayments
 * @author customweb GmbH (http://www.customweb.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0  Apache Software License (ASL 2.0)
 *//**
 * TrustPayments
 *
 * This module allows you to interact with the TrustPayments payment service using OXID eshop.
 * Using this module requires a TrustPayments account (https://ep.trustpayments.com/user/signup)
 *
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category      module
 * @package       TrustPayments
 * @author        customweb GmbH
 * @link          commercialWebsiteUrl
 * @copyright (C) customweb GmbH 2018
 */

namespace Tru\TrustPayments\Application\Controller\Admin;

use Tru\TrustPayments\Core\TrustPaymentsModule;

/**
 * Class Alert.
 */
class Alert extends \OxidEsales\Eshop\Application\Controller\Admin\AdminController
{
    protected $_sThisTemplate = 'truTrustPaymentsError.tpl';

    public function manualtask(){
        $url = TrustPaymentsModule::settings()->getBaseUrl() . '/s/' . TrustPaymentsModule::settings()->getSpaceId() . '/manual-task/list';
        \OxidEsales\Eshop\Core\Registry::getUtils()->redirect($url);
        die();
    }
}