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
            $("#app-error-container").empty().text(data['error']).show();
            $('#app-data-result').find('tbody').empty().append('<tr> <td> No Results Yet </td> </tr>');
        }else{
            $("#app-error-container").empty().hide();
            var tableTemplate = distributerApp.resultTemplate(data.success);
            $('#app-data-result').find('tbody').empty().append(tableTemplate);
        }
        return;
    },
    resultTemplate : function(data){
        // $('#app-data-result')
        var htmlTpl = '';
        var _tmpTotal = 0;
        console.log(data);

        $.each(data, function (i, item) {
            htmlTpl     += '<tr>';
            htmlTpl     += '<th>' + item.date + '</th><td>' + item.amount + '</td>';
            htmlTpl     += '</tr>';
            _tmpTotal   += item.amount;
        })
        console.log("dd",_tmpTotal);
        return htmlTpl;
    }
}

$(document).ready(function () {
    distributerApp.init();
});