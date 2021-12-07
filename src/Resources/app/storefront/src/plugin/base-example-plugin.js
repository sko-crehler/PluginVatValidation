import Plugin from 'src/plugin-system/plugin.class';
import StoreApiClient from 'src/service/store-api-client.service';
import ElementLoadingIndicatorUtil from 'src/utility/loading-indicator/element-loading-indicator.util';

export default class BaseExamplePlugin extends Plugin {
    static options = {
        vatIdsSelector: '#vatIds',
        companyNameSelector: '#billingAddresscompany',
        companyAddressSelector: '#billingAddressAddressStreet',
        companyZipcodeSelector: '#billingAddressAddressZipcode',
        companyCitySelector: '#billingAddressAddressCity',
        isLoading: '',
    }

    init() {
        this._client = new StoreApiClient();
        this.$vatIds = this.el.querySelector(this.options.vatIdsSelector);
        this.$companyName = this.el.querySelector(this.options.companyNameSelector);
        this.$companyAddress = this.el.querySelector(this.options.companyAddressSelector);
        this.$companyZipcode = this.el.querySelector(this.options.companyZipcodeSelector);
        this.$companyCity = this.el.querySelector(this.options.companyCitySelector);

        this._registerEvents();
    }

    _registerEvents() {
        this.$vatIds.addEventListener('change', this._onChange.bind(this));
    }

    _onChange(event) {
        // if (this._validateNip(event.target.value)) {
            this._fetchData(event.target.value);
        // }
    }

    _fetchData(vatId) {
        ElementLoadingIndicatorUtil.create(this.$vatIds.parentNode);

        this._client.get(`store-api/govapi/vat/${vatId}`, this._handleData.bind(this));
    }

    _handleData(response) {
        ElementLoadingIndicatorUtil.remove(this.$vatIds.parentNode);

        const result = JSON.parse(response);
        const newaddress = result.traderAddress.replace('\n', ', ');
        const [, address, zipCode, city] = newaddress.match(/^([^,]+), (\S+) ([^,]+)$/);

        this.$companyName.value = result.traderName;
        this.$companyAddress.value = this._titleCase(address);
        this.$companyZipcode.value = zipCode;
        this.$companyCity.value = this._titleCase(city);
    }

    _validateNip(nip) {
        if (typeof nip === "number") {
            nip = nip.toString();
        } else {
            nip = nip.replace(/-/g, "");
        }

        if (nip.length !== 10) {
            return false;
        }

        const nipArray = nip.split("").map(value => parseInt(value));
        const checkSum = (6 * nipArray[0] + 5 * nipArray[1] + 7 * nipArray[2] + 2 * nipArray[3] + 3 * nipArray[4] + 4 * nipArray[5] + 5 * nipArray[6] + 6 * nipArray[7] + 7 * nipArray[8]) % 11;

        return nipArray[9] == checkSum;
    }

    _titleCase(str) {
        return str.split(' ').map(function(val){
            return val.charAt(0).toUpperCase() + val.substr(1).toLowerCase();
        }).join(' ');
    }
}

