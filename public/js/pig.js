$(".dropdown-button").dropdown();
$('.showSideNav').sideNav({
  menuWidth: 100, // Default is 240
  //edge: 'right', // Choose the horizontal origin
  closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
});
$('.modal').modal({
    dismissible: true, // Modal can be dismissed by clicking outside of the modal
    opacity: .5, // Opacity of modal background
    inDuration: 300, // Transition in duration
    outDuration: 200, // Transition out duration
    startingTop: '4%', // Starting top style attribute
    endingTop: '10%', // Ending top style attribute
  }
);
$(document).ready(function() {
  $('select').material_select();
  $('ul.tabs').tabs();
});
$('.datepicker').pickadate({
  selectMonths: true, // Creates a dropdown to control month
  selectYears: 15, // Creates a dropdown of 15 years to control year,
  today: 'Today',
  clear: 'Clear',
  close: 'Ok',
  closeOnSelect: false // Close upon selecting a date,
});

// document.getElementById("offspring_earnotch").disabled = true;
// document.getElementById("select_sex").disabled = true;
// document.getElementById("birth_weight").disabled = true;
document.getElementById("number_stillborn").disabled = true;
document.getElementById("number_mummified").disabled = true;
document.getElementById("date_weaned").disabled = true;
// document.getElementById("weaning_weight").disabled = true;

var farrowed = document.getElementById("date_farrowed");
farrowed.onchange = function () {
   if (this.value != null || this.value.length > 0) {
      document.getElementById("offspring_earnotch").disabled = false;
      document.getElementById("select_sex").disabled = false;
      document.getElementById("birth_weight").disabled = false;
      document.getElementById("number_stillborn").disabled = false;
      document.getElementById("number_mummified").disabled = false;
   }
}

var weaned = document.getElementById("date_weaned");
weaned.onchange = function () {
  if (this.value != null || this.value.length > 0) {
      document.getElementById("weaning_weight").disabled = false;
  }
}