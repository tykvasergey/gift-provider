
define([
    'jquery',
    'uiRegistry',
    'jquery/ui'
], function ($, registry) {
    'use strict';

    $.widget('mage.triggerSendGiftModal', {
        options: {
            email:  null,
            modal:  null
        },

        /**
         * Show modal
         */
        showModal: function () {
            let form = registry.get('index = send_gift_form_loader');
            let modal = registry.get('index = send_gift_modal');
            form.updateData({'email': this.options.email});
            modal.openModal();
        }

    });

    return $.mage.triggerSendGiftModal;
});
