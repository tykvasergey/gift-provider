/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'Magento_Ui/js/form/components/insert-form',
    'mageUtils',
    'underscore'
], function ($,Insert, utils, _) {
    'use strict';

    return Insert.extend({
        defaults: {
            listens: {
                responseData: 'onResponse'
            },
            modules: {
                giftModalProvider: '${ $.giftModalProvider }'
                // ownerComponent: '${ $.ownerComponent }'
            }
        },

        requestData: function (params, ajaxSettings) {
            if (this.customer_email) {
                params.email = this.customer_email;
            }
            if (this.gift_id) {
                params.gift_id = this.gift_id;
            }
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

        /**
         *
         * @param {Object} responseData
         */
        onResponse: function (responseData) {
            debugger;
            if (responseData.status !== 'Error') {
                // @todo reset form data and show errors if so
                // this.addressListing().reload({
                //     refresh: true
                // });

            }
            this.giftModalProvider().closeModal();
            //this.ownerComponent().reload(); - it is provider, we need a form or messageList
        }
    });
});
