> This plugin supports the Trust Enterprise Platform which can be identified by the URL for the platform ep.trustpayments.com.

# OXID 6.X

v1.0.45, 2023-4

This repository contains the OXID  Trust Payments payment module that enables the shop to process payments with [Trust Payments](https://www.trustpayments.com/).

##### To use this extension, a [Trust Payments](https://ep.trustpayments.com/user/signup) account is required.

## Requirements

* [Oxid](https://www.oxid-esales.com/) 6.0, 6.1, 6.2, 6.10
* [PHP](http://php.net/) 5.6 or later

## Install Oxid 6.2+

 Run on the same path via terminal (required on oxid 6.2 upwards) this command to install the plugin: +
```
composer require trustpayments/oxid-6.0
```
If the plugin still don't work you need to run these commands:
```
./vendor/bin/oe-console oe:module:install source/modules/tru/TrustPayments
./vendor/bin/oe-console oe:module:install-configuration source/modules/tru/TrustPayments
./vendor/bin/oe-console oe:module:activate TrustPayments
./vendor/bin/oe-console oe:module:apply-configuration
```

## Support

Support queries can be issued on the [Trust Payments support site](https://www.trustpayments.com/contact-us/).

## Documentation

* [English](https://plugin-documentation.ep.trustpayments.com/TrustPayments/oxid-6.0/1.0.45/docs/en/documentation.html)

## License

Please see the [license file](https://github.com/TrustPayments/oxid-6.0/blob/1.0.45/LICENSE) for more information.