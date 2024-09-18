require('./bootstrap');

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'select2';
$(document).ready(function() {
    $('.select2').select2();
});
