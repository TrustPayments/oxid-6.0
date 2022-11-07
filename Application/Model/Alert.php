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


/**
 * Class Alert.
 */
class Alert
{
    const KEY_MANUAL_TASK = 'manual_task';

    protected static function getTableName()
    {
        return 'truTrustPayments_alert';
    }

    public static function setCount($key, $count) {
        $count = (int)$count;
        $key = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->quote($key);
        $query = "UPDATE `truTrustPayments_alert` SET `trucount`=$count WHERE `trukey`=$key;";
        return \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->execute($query) === 1;
    }

    public static function modifyCount($key, $countModifier = 1) {
        $countModifier = (int)$countModifier;
        $key = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->quote($key);
        $query = "UPDATE `truTrustPayments_alert` SET `TRUCOUNT`=`TRUCOUNT`+$countModifier WHERE `trukey`=$key;";
        return \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->execute($query) === 1;
    }

    public static function loadAll() {
        $query = "SELECT `TRUKEY`, `TRUCOUNT`, `TRUFUNC`, `TRUTARGET` FROM `truTrustPayments_alert`";
        return \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll($query);
    }
}