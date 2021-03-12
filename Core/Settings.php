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

namespace Tru\TrustPayments\Core;

use Monolog\Logger;

/**
 * Class Settings
 * Handles access to module settings.
 *
 * @codeCoverageIgnore
 */
class Settings {

    public function getLogFile(){
        return dirname(OX_LOG_FILE) . '/TrustPayments.log';
    }
    public function getCommunicationsLog(){
        return dirname(OX_LOG_FILE) . '/TrustPayments_communication.log';
    }

	public function getBaseUrl(){
		return 'https://app-wallee.com';
	}

	public function getSpaceId(){
		return $this->getSetting('SpaceId');
	}

	public function getSpaceViewId(){
		return $this->getSetting('SpaceViewId');
	}

	public function isDownloadInvoiceEnabled(){
		return $this->getSetting('InvoiceDoc');
	}

	public function isDownloadPackingEnabled(){
		return $this->getSetting('PackingDoc');
	}
	
	public function enforceLineItemConsistency() {
		return $this->getSetting('EnforceConsistency');
	}

	public function isEmailConfirmationActive() {
	    return $this->getSetting('EmailConfirm');
    }

	public function isLogCommunications(){
		return $this->getLogLevel() === 'DEBUG';
	}

	public function getMappedLogLevel(){
		switch ($this->getLogLevel()) {
			case 'ERROR':
				// ERROR, CRITICAL, ALERT, EMERGENCY
				return Logger::ERROR;
			case 'DEBUG':
				// DEBUG
				return Logger::DEBUG;
			case 'INFO':
				// INFO, NOTICE, WARNING
				return Logger::WARNING;
			default:
				return Logger::WARNING;
		}
	}

	public function getUserId(){
		return \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('truTrustPaymentsUserId', \OxidEsales\Eshop\Core\Registry::getConfig()->getBaseShopId(),\OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
	}

	public function getAppKey(){
		return \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('truTrustPaymentsAppKey', \OxidEsales\Eshop\Core\Registry::getConfig()->getBaseShopId(),\OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
	}

	public function getMigration() {
		$level = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('truTrustPaymentsMigration', \OxidEsales\Eshop\Core\Registry::getConfig()->getBaseShopId(),\OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
		if(!$level) {
            $level = 0;
        }
        return $level;
    }

    public function setMigration($level) {
    	\OxidEsales\Eshop\Core\Registry::getConfig()->saveShopConfVar('num', 'truTrustPaymentsMigration', $level, \OxidEsales\Eshop\Core\Registry::getConfig()->getBaseShopId(), \OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
    }

	protected function getLogLevel(){
		return strtoupper($this->getSetting('LogLevel'));
	}

	/**
	 * Get module setting value.
	 *
	 * @param string $sModuleSettingName Module setting parameter name (key).
	 * @param boolean $blUseModulePrefix If True - adds the module settings prefix, if False - not.
	 *
	 * @return mixed
	 */
	protected function getSetting($sModuleSettingName, $blUseModulePrefix = true){
		if ($blUseModulePrefix) {
			$sModuleSettingName = 'truTrustPayments' . (string) $sModuleSettingName;
		}
		return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam((string) $sModuleSettingName);
	}

	protected function setSetting($value, $sModuleSettingName, $blUseModulePrefix = true){
        if ($blUseModulePrefix) {
            $sModuleSettingName = 'truTrustPayments' . (string) $sModuleSettingName;
        }
        \OxidEsales\Eshop\Core\Registry::getConfig()->setConfigParam((string) $sModuleSettingName, $value);
    }

	public function getWebhookUrl() {
		return \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('truTrustPaymentsWebhook', \OxidEsales\Eshop\Core\Registry::getConfig()->getBaseShopId(),\OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
    }

    public function setWebhookUrl($value) {
    	\OxidEsales\Eshop\Core\Registry::getConfig()->saveShopConfVar('string', 'truTrustPaymentsWebhook', $value, \OxidEsales\Eshop\Core\Registry::getConfig()->getBaseShopId(), \OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
    }

    public function setGlobalParameters($shopId = null) {
    	$appKey = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('truTrustPaymentsAppKey', $shopId, \OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
    	$userId = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('truTrustPaymentsUserId', $shopId, \OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
    	foreach(\OxidEsales\Eshop\Core\Registry::getConfig()->getShopIds() as $shop) {
	    	\OxidEsales\Eshop\Core\Registry::getConfig()->saveShopConfVar('str', 'truTrustPaymentsAppKey', $appKey, $shop, \OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
	    	\OxidEsales\Eshop\Core\Registry::getConfig()->saveShopConfVar('str', 'truTrustPaymentsUserId', $userId, $shop, \OxidEsales\Eshop\Core\Config::OXMODULE_MODULE_PREFIX . TrustPaymentsModule::instance()->getId());
    	}
    }
}