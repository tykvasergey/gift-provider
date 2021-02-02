define([
    'Magento_Ui/js/grid/columns/column',
    'jquery',
    'mage/template',
    'text!WiserBrand_RealThanks/templates/grid/gift/send-form.html',
    'mage/translate',
    'Magento_Ui/js/modal/modal',
    'mage/cookies'
], function (Column, $, mageTemplate, sendmailPreviewTemplate, $t) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/html',
            fieldClass: {
                'data-grid-html-cell': true
            }
        },
        getHtml: function () {
             return "<button class='button'><span>" + $t('Send Gift') + "</span></button>";
             },
        getLabel: function (row) {
            return "<button class='button'><span>" + $t('Send Gift') + "</span></button>";
        },
        getFormAction: function (row) {
            return row[this.index + '_action'];
        },
        getGiftId: function (row) {
            return row[this.index + '_gift_id'];
        },
        getFormKey: function (row) {
            return row[this.index + '_form_key'];
        },
        getTitle: function () {
            return $t('Please fill a gift form');
        },
        getSubmitLabel: function () {
            return $t('Send');
        },
        getCancelLabel: function () {
            return $t('Reset');
        },
        getEmailLabel: function () {
            return $t('Email:');
        },
        getSubjectLabel: function () {
            return $t('Subject:');
        },
        getMessageLabel: function () {
            return $t('Add your message here:');
        },
        preview: function (row) {
            let modalHtml = mageTemplate(
                sendmailPreviewTemplate,
                {
                    title: this.getTitle(),
                    label: this.getLabel(),
                    form_action: this.getFormAction(row),
                    gift_id: this.getGiftId(row),
                    submit_label: this.getSubmitLabel(),
                    cancel_label: this.getCancelLabel(),
                    email_label: this.getEmailLabel(),
                    message_label: this.getMessageLabel(),
                    subject_label: this.getSubjectLabel(),
                    //form_key: $.mage.cookies.get('form_key'),
                    form_key: this.getFormKey(row),
                    linkText: $.mage.__('Go to Details Page') //? what is it
                }
            );
            let previewPopup = $('<div/>').html(modalHtml);
            previewPopup.modal({
                title: this.getTitle(),
                innerScroll: true,
                modalClass: '_image-box',
                buttons: []}).trigger('openModal');
        },
        getFieldHandler: function (row) {
            return this.preview.bind(this, row);
        }
    });
});
