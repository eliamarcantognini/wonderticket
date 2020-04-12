function load_unseen_notification(view = '') {
  baseURL = window.location.origin+"/wonderticket/public/";
  $.ajax({
    url: baseURL+"notifies",
    method:"GET",
    dataType:"json",
    success:function(data) {
      $('#notifiesList #notifiesContainer').empty();
      $('#notifyCounter').empty();
      if(data != undefined && data.notifies.length > 0) {
          $('#notifiesList').html("<li class='head bg-secondary text-right rounded-top py-1 px-2'><div class='row'><div class='col-6 text-left'><small class='text-white'>Notifications</small></div>"+
            "<div class='col-6'><small><a id='readAllBtn' href='' class='text-white'>Mark all as read</a></small></div></div></li>"+
            "<div id='notifiesContainer'></div><li class='footer bg-secondary rounded-bottom text-center p-1'></li>");
          addBtnAllListener();
          $.each(data.notifies, function(i, item) {
          bgcolor = item.read ? '' : 'bg-light';
          html = "<a href='"+baseURL+"events/' class='list-group-item rounded-0 list-group-item-action "+bgcolor+"' alert="+item.alert_id+" event_id="+item.event_id+" read="+item.read+">"+
            "<div class='row'>"+
              "<div class='col-8 px-1 '>"+
                "<strong>"+item.title+"</strong>"+
              "</div>"+
              "<div class='col-4 px-1'>"+
                "<small class='text-muted mt-auto'>"+new Date(item.date).toLocaleDateString()+"</small>"+
              "</div>"+
              "<div class='col-12 px-1'>"+
                "<small>"+item.text+"</small>"+
              "</div>"+
            "</div>"+
          "</a>";
          $('#notifiesList #notifiesContainer').append(html);
          //$('#notifiesList #notifiesContainer row').click(readNotification);
          $('#notifiesList #notifiesContainer a').click(readNotification);
        });
        if(data.unread > 0) {
          $('#notifyCounter').append(data.unread);
        }
      } else {
        $('#notifiesList').html(
            "<li class='head bg-secondary rounded-top text-left py-1 px-2'><small class='text-white'>Notifications</small></li>"+
            "<li class='p-2'>No notifications</li>"+
            "<li class='footer bg-secondary rounded-bottom text-center p-1'><li>");
      }
    }
  });
}


function readNotification(event) {
  baseURL = window.location.origin+"/wonderticket/public/";
  event.preventDefault();
  const alert = $(this).attr('alert');
  const dest = $(this).attr('href');
  let event_id = $(this).attr('event_id');
  if(event_id == 'null') {
    event_id = -1;
  }
  const read = $(this).attr('read');
  if(read == 0) {
    $.ajax({
      url: baseURL+"notifies",
      method:"POST",
      data: {
        _method: 'put',
        alert_id: alert,
        event_id: event_id,
      },
      success:function(data) {
        if(event_id > -1) {
          window.location = dest+event_id;
        } else {
          load_unseen_notification();
        }
      }
    });
  } else {
    if(event_id > -1) {
      window.location = dest+event_id;
    } else {
      load_unseen_notification();
    }
  }
}

function loadCartItems() {
  baseURL = window.location.origin+"/wonderticket/public/";
  $.ajax({
    url: baseURL+"cart/count",
    method:"GET",
    dataType:"json",
    success:function(cartItems) {
      $('#notifyCart').empty();
      if(cartItems != undefined) {
        $('#notifyCart').append(cartItems);
      }
    }
  });
}

$(document).ready(function(){
  load_unseen_notification();
  loadCartItems();

  // load new notifications
  $("#notifiesBtn").click(function() {
    $('.count').html('');
    $('#navbarCollapse').collapse('hide');
    load_unseen_notification('yes');
  });

  setInterval(function(){
    load_unseen_notification();
  }, 10000);

  setInterval(function(){
    loadCartItems();
  }, 1000);

});

function addBtnAllListener() {
  $('#readAllBtn').click(function(event) {
    baseURL = window.location.origin+"/wonderticket/public/";
    event.preventDefault();
    $.ajax({
      url: baseURL+"notifies",
      method:"POST",
      data: {
        _method: 'put',
      },
      success:function() {
        load_unseen_notification();
      }
    });
  });
}

/*function createNotification() {
  // submit form and get new records
  $('#comment_form').on('submit', function(event) {
    event.preventDefault();
    if($('#subject').val() != '' && $('#comment').val() != '') {
      var form_data = $(this).serialize();
      $.ajax({
        url:"insert.php",
        method:"POST",
        data:form_data,
        success:function(data) {
          $('#comment_form')[0].reset();
          load_unseen_notification();
        }
      });
    } else {
      alert("Both Fields are Required");
    }
  });
}*/