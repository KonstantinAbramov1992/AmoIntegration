define(['jquery', 'underscore', 'twigjs', 'lib/components/base/modal',
    './plugins/select2/select2.min.js', "./helpers.js"
], function ($, _, Twig, Modal) {
    "use strict";
    let newCard, issetLeads;

    let CustomWidget = function () {

        const self = this,
            API_HOST = 'https://fce7-109-252-65-125.ngrok.io/api',
            AMOJO_ID = AMOCRM.constant('account').amojo_id;

        this.callbacks = {
            render: function () {
                console.debug('render');
                return true;
            },
            init: function () {
                console.debug('init');
                return true;
            },
            bind_actions: function () {
                console.debug('bind_actions');
                
                return true;
            },
            dpSettings: function () {
                console.debug('dpSettings');
                return true;
            },
            settings: function () {
                console.debug('settings');
                return true;
            },
            onSave: function (e) {
                console.debug('onSave');
                return true;
            },
            destroy: function (e) {
                console.debug('destroy');
            },
            contacts: {
                //select contacts in list and clicked on widget name
                selected: function () {
                    console.debug('contacts selected');
                }
            },
            leads: {
                //select leads in list and clicked on widget name
                selected: function () {
                    console.debug('leads selected');
                }
            },
            tasks: {
                //select taks in list and clicked on widget name
                selected: function () {
                    console.debug('tasks selected');
                }
            },
            advancedSettings: function () {
                console.debug('advancedSettings');
            },

            /**
             * ?????????? ??????????????????????, ?????????? ???????????????????????? ?? ???????????????????????? Salesbot ?????????????????? ???????? ???? ?????????????????? ??????????????.
             * ???? ???????????? ?????????????? JSON ?????? salesbot'??
             *
             * @param handler_code - ?????? ????????????????, ?????????????? ???? ??????????????????????????. ???????????? ?? manifest.json, ?? ?????????????? ?????????? handler_code
             * @param params - ???????????????????? ?????????????????? ??????????????. ???????????? ??????????:
             * {
             *   button_title: "TEST",
             *   button_caption: "TEST",
             *   text: "{{lead.cf.10929}}",
             *   number: "{{lead.price}}",
             *   url: "{{contact.cf.10368}}"
             * }
             *
             * @return {{}}
             */
            onSalesbotDesignerSave: function (handler_code, params) {
                console.debug('onSalesbotDesignerSave');
                console.debug(handler_code);
                console.debug(params);
            },
        };
        return this;
    };
    return CustomWidget;
});
