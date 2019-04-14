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
                   // console.log(data);
                    
                    distributerApp.getFormData(data);
                }
            });
        });
    },

    initDatePicker() {
        distributerApp.dom.dateInputs.find('input').each(function () {
            $(this).datepicker({
                'clearDates': true,
                'format': 'yyyy-mm-dd',
                'autoclose' : true
            });
        });
    },
    getFormData : function(data){
        if (data.hasOwnProperty('error')) {
            console.log(data['error']);
            $("#app-error-container").empty().text(data['error']).show();
            return;
        }else{
            $("#app-error-container").empty().hide();

            console.log("Success");
            console.log(data);
        }
    }
}

$(document).ready(function () {
    distributerApp.init();
});