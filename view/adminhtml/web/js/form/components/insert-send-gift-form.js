/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'uiRegistry',
    'Magento_Ui/js/form/components/insert-form',
    'mageUtils',
    'underscore',
    'mage/apply/main',
    'notification'
], function ($, registry, Insert, utils, _, mage, notification) {
    'use strict';

    return Insert.extend({
        defaults: {
            listens: {
                responseData: 'onResponse',
                '${ $.giftModalProvider }:openModal' : 'onOpenModal'
            },
            modules: {
                giftModalProvider: '${ $.giftModalProvider }',
                ownerComponent: '${ $.ownerComponent }'
            }
        },

        requestData: function (params, ajaxSettings) {
            // === @todo refactor these statements:
            if (this.customer_email) {
                params.email = this.customer_email;
            } else if (this.previousParams.email) {
                params.email = this.previousParams.email;
            }
            if (this.gift_id) {
                params.gift_id = this.gift_id;
            } else  if (this.gift_id) {
                params.gift_id = this.previousParams.gift_id;
            }
            // ===
            let query = utils.copy(params);
            ajaxSettings = _.extend({
                url: this['update_url'],
                method: 'GET',
                data: query,
                dataType: 'json'
            }, ajaxSettings);

            this.loading(true);

            return $.ajax(ajaxSettings);
        },

        onOpenModal: function () {
            // clear previous messages
            //@todo moves to the modal component, here it dosen`t invoke
            $('#rt_message_wrap').remove();
            // ===
        },

        /**
         * @param {Object} responseData
         */
        onResponse: function (responseData) {
            if (responseData.status !== 'Error') {
                this.giftModalProvider().closeModal();
                this.resetForm();
            } else {

            }
            this.showMessage(responseData);
        },

        showMessage: function (responseData) {
            let giftContext = !!this.previousParams.gift_id;
            $('body').notification('clear')
                .notification('add', {
                    error: responseData.status === 'Error',
                    message: responseData.message,
                    giftContext: giftContext,

                    insertMethod: function (message) {
                        let $wrapper = $('<div/>').attr('id', 'rt_message_wrap').html(message);

                        if (this.giftContext) {
                            $('.page-columns').before($wrapper);
                        } else {
                            $('.page-main-actions:first-of-type').after($wrapper);
                        }
                    }
                });
        }
    });
});
