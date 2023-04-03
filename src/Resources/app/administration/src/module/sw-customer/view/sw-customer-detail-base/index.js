import template from './sw-customer-detail-base.html.twig';
import './sw-customer-detail-base.scss';

const { Component } = Shopware;
const { Criteria } = Shopware.Data;

Component.override('sw-customer-detail-base', {
    template,

    inject: ['repositoryFactory'],

    data() {
        return {
            pkdCodes: [],
            areCodesReady: false
        };
    },

    computed: {
        customerRepository() {
            return this.repositoryFactory.create('customer');
        },
    },

    methods: {
        fetchCustomerWithPkdCodes() {
            const criteria = new Criteria();
            criteria.addAssociation('pkdCodes');
            criteria.addFilter(Criteria.equals('id', this.customer.id));
            const that = this;
            this.customerRepository.search(criteria).then(customer => {
                const pkdCodes = customer.first().extensions.pkdCodes;
                let number = 1;
                pkdCodes.forEach(pkdCode => {
                    that.pkdCodes.push({
                        number: number,
                        code: pkdCode.pkdCode
                    });
                    ++number;
                });
                if (number > 1) {
                    that.areCodesReady = true;
                }
            });
        }
    },

    created() {
        this.createdComponent();
        this.fetchCustomerWithPkdCodes();
    },
});