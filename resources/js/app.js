require('./bootstrap');

window.moment = require('moment');
window.bootstrap = require('bootstrap');

import IMask from 'imask';
import { Datepicker } from 'vanillajs-datepicker';

window.setFormNumber = (elem) => {
    IMask(
        elem,
        {
            mask: Number,
            min: elem.getAttribute('min'),
            max: elem.getAttribute('max'),
            thousandsSeparator: '.'
        }
    );
}

var form_number = document.querySelectorAll('.form-number');
for(var i = 0; i < form_number.length; i++){
    setFormNumber(form_number[i])
}

var form_phone = document.querySelectorAll('.form-phone');
for(var i = 0; i < form_phone.length; i++){
    IMask(
        form_phone[i],
        {
            mask: /^\d+$/
        }
    );
}

var form_date = document.querySelectorAll('.form-date');
for(var i = 0; i < form_date.length; i++){
    new Datepicker(form_date[i], {
        format: 'dd/mm/yyyy',
        autohide: true
    }); 
}

window.toCurrency = function (number){
    var string = number.toString();
    var input = string.replace(/[\D\s\._\-]+/g, "");
    input = input ? parseInt( input, 10 ) : 0;
    
    return ( input === 0 ) ? "" : input.toLocaleString( "id-ID" );
}