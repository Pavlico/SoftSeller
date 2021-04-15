 define([
    'uiComponent',
    'escaper'
], function (Component, escaper) {
    'use strict';

    var quoteItemData = window.checkoutConfig.quoteItemData;
    return Component.extend({
        defaults: {
            template: 'Softserve_Seller/summary/item/details'
        },
        quoteItemData: quoteItemData,
        /**
         * @param {Object} quoteItem
         * @return {String}
         */
        getNameUnsanitizedHtml: function (quoteItem) {
            var txt = document.createElement('textarea');

            txt.innerHTML = quoteItem.name;

            return escaper.escapeHtml(txt.value, this.allowedTags);
        },

        /**
         * @param {Object} quoteItem
         * @return {String}Magento_Checkout/js/region-updater
         */
        getValue: function (quoteItem) {
            return quoteItem.name;
        },
        getSeller: function(quoteItem) {
            var item = this.getItem(quoteItem.item_id);
            if(item.seller){
                return item.seller;
            }else{
                return '';
            }
        },
        getItem: function(item_id) {
            var itemElement = null;
            _.each(this.quoteItemData, function(element, index) {
                if (element.item_id == item_id) {
                    itemElement = element;
                }
            });
            return itemElement;
        }
    });
});
