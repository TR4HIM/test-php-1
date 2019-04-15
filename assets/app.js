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

        // Date picker init
        distributerApp.initDatePicker();
        // Init all events
        distributerApp.events();
    },

    events: function () {

        //Event to get data
        distributerApp.dom.btnCalculate.on('click',function(e){
            e.preventDefault();
            var _this = $(this);

            // Change text and disable the button on loading
            _this.text('Loading ...').attr('disabled','disabled');

            var form    = $('#app-distributer-form');
            var url     = form.attr('action');

            //Send AJAx request to backend 
            $.ajax({
                type    : "POST",
                url     : url,
                data    : form.serialize(), 
                success: function (data) {
                    // If success get data and pass it to getFormData function
                    distributerApp.getFormData(data);
                    //Remove disabled on button
                    _this.text('Calculate').removeAttr('disabled');
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

        // Check if there's an error
        if (data.hasOwnProperty('error')) {
            //Show the error
            $("#app-error-container").empty().text(data['error']).show();
            // Remove old results
            $('#app-data-result').find('tbody').empty().append('<tr> <td> No Results Yet </td> </tr>');
        }else{
            //Hide the error box if there's no errors
            $("#app-error-container").empty().hide();
            //Generate an HTML tempalte with a helper function
            var tableTemplate = distributerApp.resultTemplate(data.success);
            //Appedn the template to Show result container
            $('#app-data-result').find('tbody').empty().append(tableTemplate);
        }
        return;
    },
    resultTemplate : function(data){
        var htmlTpl = '';
        $.each(data, function (i, item) {
            htmlTpl     += '<tr>';
            htmlTpl     += '<th>' + item.date + '</th><td>' + item.amount + '</td>';
            htmlTpl     += '</tr>';
        })
        return htmlTpl;
    }
}

$(document).ready(function () {
    distributerApp.init();
});