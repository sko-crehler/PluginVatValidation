import BaseExamplePlugin from './plugin/base-example-plugin.js';

const PluginManager = window.PluginManager;

PluginManager.register('BaseExamplePlugin', BaseExamplePlugin, '.register-form');