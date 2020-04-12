$(document).ready(function() {

  $('#removeAlert').click(function(event) {
    event.preventDefault();
    dest = $(this).attr('href');
    loadSpinner($(this));
    $.ajax({
      url: dest,
      method:"POST",
      data: {
        _method: 'delete',
      },
      success:function() {
        changeButton($('#addAlert'));
      }
    });
  });

  $('#addAlert').click(function(event) {
    event.preventDefault();
    dest = $(this).attr('href');

    loadSpinner($(this));
    $.ajax({
      url: dest,
      method:"POST",
      success:function() {
        changeButton($('#removeAlert'));
      }
    });
  });

});

function loadSpinner(btn) {
  btn.toggleClass("d-none");
  $("#spinner").toggleClass("d-none");
}

function changeButton(btn) {
  btn.removeClass("d-none");
  $("#spinner").addClass("d-none");
}
