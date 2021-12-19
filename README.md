# PluginVatValidation

<sub><sup>**Note**: _This plugin is described in detail on the author's software engineering blog. The article can be found at [this](https://pietrzakadrian.com/blog/accelerate-the-purchasing-process-in-e-commerce-based-on-shopware-6) link._<sup></sub>

## Description

European VAT Reg.No. Validation integration plugin for [Shopware 6](https://github.com/shopware/platform).

- Checks if the VAT Reg.No. entered is according to the correct format.
- Automatically enters data into the company name and address fields from the VIES.
- Allows you to set the required field for vat number.

## Preview

<p align="center">
  <img src="https://pietrzakadrian.com/1a633aa453c9a2e09bce0764e8e36435/preview2.gif">
</p>

## FAQ

**1. The VAT-ID is not being recognized.**

The VAT-ID is verified live by contacting the VIES servers which are only available during 5:00 AM and 11:00 PM.

Please make sure that the company information data is entered in the online form exactly as it has been registered. You can check the exact registration information for your company via [this](https://ec.europa.eu/taxation_customs/vies/vatResponse.html?locale=en) link.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
