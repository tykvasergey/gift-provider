/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'ko',
    'mageUtils',
    'Magento_Ui/js/form/element/abstract'
], function (ko, utils, Abstract) {
    'use strict';


    return Abstract.extend({
        defaults: {
            links: {
                value: ''
            }
        },
        srcLink : ko.observable(''),

        /**
         * Initializes file component.
         *
         * @returns {Media} Chainable.
         */
        initialize: function () {
            this._super()
                .initFormId();

            return this;
        },

        getSrc: function () {
            var self = this;
            return self.srcLink;
        },

        /**
         * Defines form ID with which file input will be associated.
         *
         * @returns {Media} Chainable.
         */
        initFormId: function () {
            var namespace;

            if (this.formId) {
                return this;
            }

            namespace   = this.name.split('.');
            this.formId = namespace[0];

            return this;
        }
    });
});
