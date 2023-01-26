import FormValidation from "src/plugin/forms/form-validation.plugin";
import { checkVAT, countries } from 'jsvat';

export default class FormVatValidationPlugin extends FormValidation {
    static options = {
        ...FormValidation.options,
        vatAttr: 'data-form-validation-vat-valid',
    };


    _registerEvents() {
        super._registerEvents();

        this._registerValidationListener(this.options.vatAttr, this._onValidateVat.bind(this), ['change']);
    }

    _onValidateVat(event) {
        const field = event.target;
        const value = field.value.trim();
        const { isValid } = checkVAT(value, countries);

        if (value && !isValid) {
            this._setFieldToInvalid(field, this.options.vatAttr);
        } else {
            this._setFieldToValid(field, this.options.vatAttr);
        }

        this.$emitter.publish('onValidateVat');
    }
}
