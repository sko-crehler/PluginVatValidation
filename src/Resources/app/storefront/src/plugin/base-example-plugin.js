import Plugin from 'src/plugin-system/plugin.class';
import StoreApiClient from 'src/service/store-api-client.service';
import ElementLoadingIndicatorUtil from 'src/utility/loading-indicator/element-loading-indicator.util';
import { checkVAT, countries } from 'jsvat';

export default class BaseExamplePlugin extends Plugin {
    static options = {
        vatIdsSelector: '#vatIds',
        companyNameSelector: '#billingAddresscompany',
        companyAddressSelector: '#billingAddressAddressStreet',
        companyZipcodeSelector: '#billingAddressAddressZipcode',
        companyCitySelector: '#billingAddressAddressCity',
        companyCountrySelector: '#billingAddressAddressCountry',
        vatTipSelector: '.vat-tip',
    }

    init() {
        this._client = new StoreApiClient();
        this.$vatIds = this.el.querySelector(this.options.vatIdsSelector);
        this.$companyName = this.el.querySelector(this.options.companyNameSelector);
        this.$companyAddress = this.el.querySelector(this.options.companyAddressSelector);
        this.$companyZipcode = this.el.querySelector(this.options.companyZipcodeSelector);
        this.$companyCity = this.el.querySelector(this.options.companyCitySelector);
        this.$companyCountry = this.el.querySelector(this.options.companyCountrySelector);
        this.$vatTip = this.el.querySelector(this.options.vatTipSelector);
        this.$vatTipDefaultContent = this.$vatTip.textContent;

        this._registerEvents();
    }

    _registerEvents() {
        this.$vatIds.addEventListener('change', this._onChange.bind(this));
    }

    _onChange(event) {
        console.log(checkVAT(event.target.value, countries));

        if (!checkVAT(event.target.value, countries).isValid) {
            return;
        }

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

        this.$companyName.value = result.traderName;
        this.$companyAddress.value = this._titleCase(address);
        this.$companyZipcode.value = zipCode;
        this.$companyCity.value = this._titleCase(city);

        this.$vatTip.classList.add('has-success');
    }

    _titleCase(str) {
        return str.split(' ').map(function(val){
            return val.charAt(0).toUpperCase() + val.substr(1).toLowerCase();
        }).join(' ');
    }
}

