import Plugin from 'src/plugin-system/plugin.class';
import StoreApiClient from 'src/service/store-api-client.service';

export default class BaseExamplePlugin extends Plugin {
    static options = {
        vatIdsSelector: '#vatIds',
        companyNameSelector: '#billingAddresscompany',
    }

    init() {
        this._httpClient = new StoreApiClient();
        this.$vatIds = this.el.querySelector(this.options.vatIdsSelector);
        this.$companyName = this.el.querySelector(this.options.companyNameSelector);

        this._registerEvents();
    }

    _registerEvents() {
        this.$vatIds.addEventListener('change', this._onChange.bind(this));
    }

    _onChange(event) {
        if (event.target.value.length === 10) {
            this.fetchData(event.target.value);
        }
    }

    fetchData(vatId) {
        this._httpClient.get(`store-api/govapi/vat/${vatId}`, this.handleData);
    }

    handleData(response) {
        console.log(response);
    }
}

