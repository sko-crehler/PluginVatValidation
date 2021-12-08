import Plugin from 'src/plugin-system/plugin.class';
import StoreApiClient from 'src/service/store-api-client.service';
import ElementLoadingIndicatorUtil from 'src/utility/loading-indicator/element-loading-indicator.util';
import { checkVAT, countries } from 'jsvat';
import { titleCase } from "./helper/typography.helper";

export default class BaseExamplePlugin extends Plugin {
    static options = {
        vatIdsSelector: '#vatIds',
        companyNameSelector: '#billingAddresscompany',
        companyAddressSelector: '#billingAddressAddressStreet',
        companyZipcodeSelector: '#billingAddressAddressZipcode',
        companyCitySelector: '#billingAddressAddressCity',
        companyCountrySelector: '#billingAddressAddressCountry',
    }

    init() {
        this._client = new StoreApiClient();
        this.$vatIds = this.el.querySelector(this.options.vatIdsSelector);
        this.$companyName = this.el.querySelector(this.options.companyNameSelector);
        this.$companyAddress = this.el.querySelector(this.options.companyAddressSelector);
        this.$companyZipcode = this.el.querySelector(this.options.companyZipcodeSelector);
        this.$companyCity = this.el.querySelector(this.options.companyCitySelector);
        this.$companyCountry = this.el.querySelector(this.options.companyCountrySelector);

        this._registerEvents();
    }

    _registerEvents() {
        this.$vatIds.addEventListener('change', this._onChange.bind(this));
    }

    _onChange(event) {
        const { isValid, country } = checkVAT(event.target.value, countries);

        if (!isValid) {
            return false;
        }

        this._setSelectOption(this.$companyCountry, country.name)
        this._fetchData(event.target.value);
    }

    _fetchData(vatId) {
        ElementLoadingIndicatorUtil.create(this.$vatIds.parentNode);

        this._client.get(`store-api/company/${vatId}`, this._handleData.bind(this));
    }

    _handleData(response) {
        ElementLoadingIndicatorUtil.remove(this.$vatIds.parentNode);

        this._parseData(response);
    }

    _parseData(response) {
        const result = JSON.parse(response);

        if (!result.traderAddress || !result.traderName) {
            throw new Error(`Failed to parse vat validation info from VIES response`);
        }

        const partedTraderAddress = result.traderAddress.replace(/\n/g, ', ');
        const [, address, zipCode, city] = partedTraderAddress.match(/^([^,]+), (\S+) ([^,]+)$/);

        if (!address || !zipCode || !city) {
            throw new Error(`Failed to parse vat validation info from VIES response`);
        }

        this._setInputValue(this.$companyName, result.traderName);
        this._setInputValue(this.$companyAddress, address, true);
        this._setInputValue(this.$companyZipcode, zipCode);
        this._setInputValue(this.$companyCity, city, true);
    }

    _setSelectOption(element, text) {
        for (let i = 0; i < this.$companyCountry.options.length; ++i) {
            if (this.$companyCountry.options[i].text === text)
                this.$companyCountry.options[i].selected = true;
        }
    }

    _setInputValue(element, value, isTitleCase = false) {
        element.value = isTitleCase ? titleCase(value) : value;
    }
}

