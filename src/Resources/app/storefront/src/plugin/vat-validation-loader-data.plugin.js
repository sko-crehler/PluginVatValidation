import {checkVAT, countries} from "jsvat";
import Plugin from "src/plugin-system/plugin.class";
import StoreApiClient from "src/service/store-api-client.service";
import ElementLoadingIndicatorUtil from "src/utility/loading-indicator/element-loading-indicator.util";
import {titleCase} from "./helper/typography.helper";
import DomAccess from "src/helper/dom-access.helper";
import Iterator from 'src/helper/iterator.helper';

export default class VatValidationLoaderDataPlugin extends Plugin {
    static options = {
        companyVatIdSelector: "#vatIds",
        companyNameSelector: "#billingAddresscompany",
        companyAddressSelector: "#billingAddressAddressStreet",
        companyZipcodeSelector: "#billingAddressAddressZipcode",
        companyCitySelector: "#billingAddressAddressCity",
        companyCountrySelector: "#billingAddressAddressCountry",
        vatValidTextSelector: '[data-form-validation-vat-valid-text="true"]'
    };

    init() {
        this._client = new StoreApiClient();
        this.$companyVatId = DomAccess.querySelector(this.el, this.options.companyVatIdSelector);
        this.$companyName = DomAccess.querySelector(this.el, this.options.companyNameSelector);
        this.$companyAddress = DomAccess.querySelector(this.el, this.options.companyAddressSelector);
        this.$companyZipcode = DomAccess.querySelector(this.el, this.options.companyZipcodeSelector);
        this.$companyCity = DomAccess.querySelector(this.el, this.options.companyCitySelector);
        this.$companyCountry = DomAccess.querySelector(this.el, this.options.companyCountrySelector);
        this.$vatValidText = DomAccess.querySelector(this.el, this.options.vatValidTextSelector);
        this.$previousVatValidText = this.$vatValidText.innerText;

        this._registerEvents();
    }

    _registerEvents() {
        this.$companyVatId.addEventListener("change", this._onChange.bind(this));
    }

    _onChange(event) {
        const field = event.target;
        const value = field.value.trim();
        const {isValid, country} = checkVAT(value, countries);

        if (isValid) {
            this._resetAllCompanyRegistrationValues();
            void this._fetchData(value, country);
        }
    }

    _fetchData(vatId, {name}) {
        ElementLoadingIndicatorUtil.create(this.$companyVatId.parentNode);

        return new Promise((resolve, reject) => {
            this._client.get(`store-api/company/${vatId}`, (response, request) => {
                ElementLoadingIndicatorUtil.remove(this.$companyVatId.parentNode);

                if (request.status >= 400) {
                    this._handleVatValidText(false);
                    reject(`Failed to parse vat validation info from VIES response`);
                    return;
                }

                this._handleVatValidText(true);
                this._parseData(response);
                this._setSelectOption(this.$companyCountry, name);

                resolve();
            });
        });
    }

    _handleVatValidText(isVatValid) {
        if (isVatValid) {
            this.$vatValidText.innerText = this.$previousVatValidText;
            this.$vatValidText.style.color = 'inherit';
        } else {
            const invalidVatSnippet = 'Przepraszamy, centralna baza ewidencji jest tymczasowo niedostępna. Wprowadź dane ręcznie';
            if (invalidVatSnippet !== this.$vatValidText.innerText) {
                this.$previousVatValidText = this.$vatValidText.innerText;
                this.$vatValidText.style.color = 'red';
                this.$vatValidText.innerText = invalidVatSnippet;
            }
        }
    }

    _parseData(response) {
        const {traderName, traderAddress} = JSON.parse(response);
        const formattedTraderAddress = traderAddress.trim("\n").replace("\n", ", ");
        const [, address, zipCode, city] = formattedTraderAddress.match(
            /^([^,]+), (\S+) ([^,]+)$/
        );

        this._setInputValue(this.$companyName, traderName);
        this._setInputValue(this.$companyAddress, address, true);
        this._setInputValue(this.$companyZipcode, zipCode);
        this._setInputValue(this.$companyCity, city, true);
    }

    _resetAllCompanyRegistrationValues() {
        const elements = [
            this.$companyName,
            this.$companyAddress,
            this.$companyZipcode,
            this.$companyCity,
            this.$companyCountry,
        ];

        Iterator.iterate(elements, element => {
            switch (element.tagName) {
                case "INPUT": {
                    this._resetInputValue(element);
                    break;
                }

                case "SELECT": {
                    this._resetSelectOption(element);
                    break;
                }

                default: {
                    throw new Error('This element cannot be handled.')
                }
            }
        })
    }

    _setSelectOption(element, text) {
        Iterator.iterate(element.options, (_, index) => {
            if (element.options[index].text === text) {
                element.options[index].selected = true;
            }
        })
    }

    _setInputValue(element, value, isTitleCase = false) {
        element.value = isTitleCase ? titleCase(value) : value;
    }

    _resetSelectOption(element) {
        element.options[0].selected = true;
    }

    _resetInputValue(element) {
        element.value = "";
    }
}
