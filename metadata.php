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


/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id' => 'truTrustPayments',
    'title' => array(
        'de' => 'TRU :: TrustPayments',
        'en' => 'TRU :: TrustPayments'
    ),
    'description' => array(
        'de' => 'TRU TrustPayments Module',
        'en' => 'TRU TrustPayments Module'
    ),
    'thumbnail' => 'out/pictures/picture.png',
    'version' => '1.0.30',
    'author' => 'customweb GmbH',
    'url' => 'https://www.customweb.com',
    'email' => 'info@customweb.com',
    'extend' => array(
        \OxidEsales\Eshop\Application\Model\Order::class => Tru\TrustPayments\Extend\Application\Model\Order::class,
        \OxidEsales\Eshop\Application\Model\PaymentList::class => Tru\TrustPayments\Extend\Application\Model\PaymentList::class,
        \OxidEsales\Eshop\Application\Model\BasketItem::class => Tru\TrustPayments\Extend\Application\Model\BasketItem::class,
        \OxidEsales\Eshop\Application\Controller\StartController::class => Tru\TrustPayments\Extend\Application\Controller\StartController::class,
        \OxidEsales\Eshop\Application\Controller\BasketController::class => Tru\TrustPayments\Extend\Application\Controller\BasketController::class,
        \OxidEsales\Eshop\Application\Controller\OrderController::class => Tru\TrustPayments\Extend\Application\Controller\OrderController::class,
        \OxidEsales\Eshop\Application\Controller\Admin\LoginController::class => Tru\TrustPayments\Extend\Application\Controller\Admin\LoginController::class,
        \OxidEsales\Eshop\Application\Controller\Admin\ModuleConfiguration::class => Tru\TrustPayments\Extend\Application\Controller\Admin\ModuleConfiguration::class,
        \OxidEsales\Eshop\Application\Controller\Admin\NavigationController::class => Tru\TrustPayments\Extend\Application\Controller\Admin\NavigationController::class,
        \OxidEsales\Eshop\Application\Controller\Admin\OrderList::class => Tru\TrustPayments\Extend\Application\Controller\Admin\OrderList::class,
    ),
    'controllers' => array(
        'tru_trustPayments_RefundJob' => Tru\TrustPayments\Application\Controller\Admin\RefundJob::class,
        'tru_trustPayments_Cron' => Tru\TrustPayments\Application\Controller\Cron::class,
        'tru_trustPayments_Pdf' => Tru\TrustPayments\Application\Controller\Pdf::class,
        'tru_trustPayments_Webhook' => Tru\TrustPayments\Application\Controller\Webhook::class,
        'tru_trustPayments_Transaction' => Tru\TrustPayments\Application\Controller\Admin\Transaction::class,
        'tru_trustPayments_Alert' => Tru\TrustPayments\Application\Controller\Admin\Alert::class
    ),
    'templates' => array(
        'truTrustPaymentsCheckoutBasket.tpl' => 'tru/TrustPayments/Application/views/pages/truTrustPaymentsCheckoutBasket.tpl',
        'truTrustPaymentsCron.tpl' => 'tru/TrustPayments/Application/views/pages/truTrustPaymentsCron.tpl',
        'truTrustPaymentsError.tpl' => 'tru/TrustPayments/Application/views/pages/truTrustPaymentsError.tpl',
        'truTrustPaymentsTransaction.tpl' => 'tru/TrustPayments/Application/views/admin/tpl/truTrustPaymentsTransaction.tpl',
        'truTrustPaymentsRefundJob.tpl' => 'tru/TrustPayments/Application/views/admin/tpl/truTrustPaymentsRefundJob.tpl',
        'truTrustPaymentsOrderList.tpl' => 'tru/TrustPayments/Application/views/admin/tpl/truTrustPaymentsOrderList.tpl',
    ),
    'blocks' => array(
        array(
            'template' => 'page/checkout/order.tpl',
            'block' => 'shippingAndPayment',
            'file' => 'Application/views/blocks/truTrustPayments_checkout_order_shippingAndPayment.tpl'
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block' => 'checkout_order_btn_submit_bottom',
            'file' => 'Application/views/blocks/truTrustPayments_checkout_order_btn_submit_bottom.tpl'
        ),
        array(
            'template' => 'layout/base.tpl',
            'block' => 'base_js',
            'file' => 'Application/views/blocks/truTrustPayments_include_cron.tpl'
        ),
        array(
            'template' => 'login.tpl',
            'block' => 'admin_login_form',
            'file' => 'Application/views/blocks/truTrustPayments_include_cron.tpl'
        ),
    	array(
    		'template' => 'header.tpl',
    		'block' => 'admin_header_links',
    		'file' => 'Application/views/blocks/truTrustPayments_admin_header_links.tpl'
    	),
    	array(
    		'template' => 'page/account/order.tpl',
    		'block' => 'account_order_history',
    		'file' => 'Application/views/blocks/truTrustPayments_account_order_history.tpl'
    	),
    ),
	'settings' => array(
		array(
			'group' => 'truTrustPaymentsTrust PaymentsSettings',
			'name' => 'truTrustPaymentsSpaceId',
			'type' => 'str',
			'value' => ''
		),
		array(
			'group' => 'truTrustPaymentsTrust PaymentsSettings',
			'name' => 'truTrustPaymentsUserId',
			'type' => 'str',
			'value' => ''
		),
		array(
			'group' => 'truTrustPaymentsTrust PaymentsSettings',
			'name' => 'truTrustPaymentsAppKey',
			'type' => 'password',
			'value' => ''
		),
		array(
			'group' => 'truTrustPaymentsShopSettings',
			'name' => 'truTrustPaymentsEmailConfirm',
			'type' => 'bool',
			'value' => true
		),
		array(
			'group' => 'truTrustPaymentsShopSettings',
			'name' => 'truTrustPaymentsEnforceConsistency',
			'type' => 'bool',
			'value' => true
		),
		array(
			'group' => 'truTrustPaymentsShopSettings',
			'name' => 'truTrustPaymentsInvoiceDoc',
			'type' => 'bool',
			'value' => true
		),
		array(
			'group' => 'truTrustPaymentsShopSettings',
			'name' => 'truTrustPaymentsPackingDoc',
			'type' => 'bool',
			'value' => true
		),
		array(
			'group' => 'truTrustPaymentsShopSettings',
			'name' => 'truTrustPaymentsLogLevel',
			'type' => 'select',
			'value' => 'Error',
			'constraints' => 'Error|Info|Debug'
		),
		array(
			'group' => 'truTrustPaymentsSpaceViewSettings',
			'name' => 'truTrustPaymentsSpaceViewId',
			'type' => 'str',
			'value' => ''
		)
    ),
    'events' => array(
        'onActivate' => Tru\TrustPayments\Core\TrustPaymentsModule::class . '::onActivate',
        'onDeactivate' => Tru\TrustPayments\Core\TrustPaymentsModule::class . '::onDeactivate'
    )
);