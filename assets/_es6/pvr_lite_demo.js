"use strict";
var toolTip = function () {
        $("[data-toggle=\"tooltip\"]").tooltip({
            placement: "top"
        });
    },
    Demo = function () {
        "use strict";
        return {
            init         : function () {
                this.initComponent();
            },
            initComponent: function () {
                toolTip();
            },
            icons        : function () {

            }
        }
    }();
$(function () {
    Demo.init();
});