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

function disableField(){
  if(document.getElementById("recycled").checked){
    document.getElementById("date_pregnant").disabled = true;
    document.getElementById("date_pregnant").placeholder = "Disabled";
  }
  else{
    document.getElementById("date_pregnant").disabled = false;
    document.getElementById("date_pregnant").placeholder = "Pick date";
  }
}