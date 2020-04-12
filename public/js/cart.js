$(document).ready(function() {
    updateTotalPrice();

    $('.removeTicketBtn').click(function(event) {
      event.preventDefault();
      dest = $(this).attr('href');
      ticketContainer = $(this).closest('.ticketInCart');
      $.ajax({
        url: dest,
        method:"POST",
        data: {
          _method: 'delete',
        },
        success:function() {
            $(ticketContainer).remove();
            updateTotalPrice();
        }
      });
    });
  
    $('#addCartBtn').click(function(event) {
      event.preventDefault();
      dest = $(this).attr('href');
      event_id = $(this).attr('event_id');
  
      loadSpinner($(this));
      $.ajax({
        url: dest,
        method:"POST",
        data: {
          event_id: event_id,
        },
        success:function() {
          changeButton($('#addCartBtn'));
        }
      });
    });
  
    function loadSpinner(btn) {
      btn.toggleClass("d-none");
      $("#spinner2").toggleClass("d-none");
    }
    
    function changeButton(btn) {
      btn.removeClass("d-none");
      $("#spinner2").addClass("d-none");
    }

    function updateTotalPrice() {
      total_price = 0;
      $('span.price').each(function(item, index, arr) {
          total_price += parseInt($(this).text());
      });
      if(total_price == 0) {
        html = "<p class='lead mb-0'> Cart is empty. </p>"
        $('.card-body').append(html);
        $('.card-footer').remove();
      } else {
        $('#taxable').text("$ "+Math.round(total_price / 1.22)+".00");
        $('#vat').text("$ "+Math.round((total_price / 1.22) * 0.22)+".00");
        $('#total').text("$ "+total_price+".00");
      }
    }
    
  });
  