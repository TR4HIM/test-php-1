var distributerApp = {
    // Declarer DOM variables here
    dom: {
        _window             : $(window),
        pageParent          : $('html, body'),
        dateInputs          : $('.input-daterange'),
        btnCalculate        : $('#btn-calculate'),
        distributerForm     : $('#app-distributer-form'),
    },
    // Initialize 
    init: function () {
         distributerApp.initDatePicker();
         distributerApp.events();
    },

    events: function () {
        distributerApp.dom.btnCalculate.on('click',function(e){
            e.preventDefault();

            var form = $('#app-distributer-form');
            var url = form.attr('action');

            $.ajax({
                type    : "POST",
                url     : url,
                data    : form.serialize(), // serializes the form's elements.
                success: function (data) {
                    console.log(data)
                }
            });
        });
    },

    initDatePicker() {
        distributerApp.dom.dateInputs.find('input').each(function () {
            $(this).datepicker({
                'clearDates': true,
                'format': 'yyyy-mm-dd'
            });
        });
    },
    sendForm : function(){

    }
}

$(document).ready(function () {
    distributerApp.init();
});