$(".dropdown-button").dropdown();
$(document).ready(function(){
  // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
  $('.modal-trigger').leanModal();
});
$('.showSideNav').sideNav({
  menuWidth: 100, // Default is 240
  //edge: 'right', // Choose the horizontal origin
  closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
});

$(document).ready(function(){
  $('ul.tabs').tabs();
});

$(document).ready(function(){
  $('.collapsible').collapsible();
});

$('.datepicker').pickadate({
  selectMonths: true, // Creates a dropdown to control month
  selectYears: 15, // Creates a dropdown of 15 years to control year,
  today: 'Today',
  clear: 'Clear',
  close: 'Ok',
  closeOnSelect: false // Close upon selecting a date,
});