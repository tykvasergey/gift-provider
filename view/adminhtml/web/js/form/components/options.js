define([
    'jquery',
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, _, uiRegistry, select, modal, url) {
    'use strict';

    return select.extend({

        /**
         * On value change handler.
         *
         * @param {String} value
         */
        onUpdate: function (value) {
            var self = this;

            if (value) {
                var img_url = self.indexedOptions[value]['image'];
                var img = uiRegistry.get('index = image_id');
                img.srcLink(img_url);
            }

            return this._super();
        },
    });
});
