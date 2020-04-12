function countBroadcastTxtArea() {
  var text_max = 200;
  $('#count_br').html(text_max + ' remaining');

  $('#broadcastTxtArea').keyup(function() {
  var text_length = $('#broadcastTxtArea').val().length;
  var text_remaining = text_max - text_length;
  
  $('#count_br').html(text_remaining + ' remaining');
  });
}

function countUserTxtArea() {
  var text_max = 200;
  $('#count_us').html(text_max + ' remaining');

  $('#userTxtArea').keyup(function() {
  var text_length = $('#userTxtArea').val().length;
  var text_remaining = text_max - text_length;
  
  $('#count_us').html(text_remaining + ' remaining');
  });
}

  $(document).ready(function() {
    countBroadcastTxtArea();
    countUserTxtArea();
  });