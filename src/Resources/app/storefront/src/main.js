import VatValidationLoaderDataPlugin from './plugin/vat-validation-loader-data.plugin.js';
import FormVatValidationPlugin from "./plugin/form-vat-validation.plugin";

const PluginManager = window.PluginManager;

PluginManager.register('VatValidationLoaderDataPlugin', VatValidationLoaderDataPlugin, '.register-form');
PluginManager.override('FormValidation', FormVatValidationPlugin, '[data-form-validation]');