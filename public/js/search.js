function fill(Value) {
  //Assigning value to "search" div in "search.php" file.
  $('#search').val(Value);
  //Hiding "display" div in "search.php" file.
  $('#display').collapse('hide');
}
  
$(document).ready(function() {
  baseURL = window.location.origin+"/wonderticket/public/";
  $("#search").keyup(function() {
      var title = $('#search').val();
      if (title == "") {
          $("#display").collapse('hide');
      }
      else {
        $.ajax({
          type: "POST",
          url: baseURL+"events/search",
          data: {
              search: title
          },
          success: function(data) {
              $('#display #search-list').empty();
              jdata = JSON.parse(data);
              if(!jdata) {
                $('#display').collapse('hide');
              } else {
                $.each(jdata, function(i, item) {
                  $('#display #search-list').append(
                  "<li class='list-group-item'><a href='events/"+jdata[i].event_id+"'>"+jdata[i].title+"</a><br>"
                  +"<small>"+new Date(jdata[i].date).toDateString()+" : "+jdata[i].venue_name+"</small></li>");
                });
                $('#display').collapse('show');
              }
            }
        });
      }
  });

  loadEvents();

  $('#venueBtn').click(function(event) {
    event.preventDefault();
    $('#displayCategories').collapse('hide');
    $('#displayPeriod').collapse('hide');
    $('#displayVenues').collapse('toggle');
  });
  
  $('#categoryBtn').click(function(event) {
    event.preventDefault();
    $('#displayVenues').collapse('hide');
    $('#displayPeriod').collapse('hide');
    $('#displayCategories').collapse('toggle');
  });

  $('#periodBtn').click(function(event) {
    event.preventDefault();
    $('#displayVenues').collapse('hide');
    $('#displayCategories').collapse('hide');
    $('#displayPeriod').collapse('toggle');
  });

  $("#venuesList a").click(function(event) {
    selected = $('#selectedVenue');
    event.preventDefault();
    selected.text($(this).text());
    selected.attr('venueId', $(this).attr('venueId'));
    $('#displayVenues').collapse('hide');
    loadEvents();
  });

  $("#categoryList a").click(function(event) {
    selected = $('#selectedCategory');
    event.preventDefault();
    selected.text($(this).text());
    selected.attr('categoryId', $(this).attr('categoryId'));
    $('#displayCategories').collapse('hide');
    loadEvents();
  });

  $("#periodList a").click(function(event) {
    selected = $('#selectedPeriod');
    event.preventDefault();
    selected.text($(this).text());
    selected.attr('periodId', $(this).attr('periodId'));
    $('#displayPeriod').collapse('hide');
    loadEvents();
  });

  function loadEvents() {
    venue = $('#selectedVenue').attr('venueId');
    category = $('#selectedCategory').attr('categoryId');
    period = $('#selectedPeriod').attr('periodId');
    index = ($('.pagination li.active a').text())-1;
    if(index < 0) {
      index = 0;
    }
    limit = 6;
    params = "?venue="+venue+"&category="+category+"&period="+period+"&index="+index+"&limit="+limit;
    $.ajax({
      type: "GET",
      url: baseURL+"events"+params,
      success: function(data) {
          $('#events-container .row').empty();
          $('.pagination').empty();
          if(data) {
          jdata = JSON.parse(data);
          dataLength = jdata.events.length;
          pages = parseInt(((Number(jdata.tot_events)+limit-1)/limit));
            if(dataLength > 0) {
            prevDisable = index == 0 ? "disabled" : "";
            nextDisable = index == (pages-1) ? "disabled" : "";
            prevPage = "<li class='page-item "+prevDisable+"'>"+
            "<a id='prevPageBtn' class='page-link' href='' aria-label='Previous'>"+
                "<span aria-hidden='true'>&laquo;</span>"+
                "<span class='sr-only'>Previous</span>"+
            "</a></li>";
            nextPage = "<li class='page-item "+nextDisable+"'>"+
              "<a id='nextPageBtn' class='page-link' href='' aria-label='Next'>"+
                "<span aria-hidden='true'>&raquo;</span>"+
                "<span class='sr-only'>Next</span>"+
              "</a></li>";
            $('.pagination').append(prevPage);
            for(i = pages; i > 0; i--) {
                active = (i-1)==index?"active" : "";
                page_html = "<li class='page-item "+active+"'><a id='pageBtn"+i+"' class='page-link' href=''>"+i+"</a></li>";
                $(page_html).insertAfter($('#prevPageBtn').parent());
                $("#pageBtn"+i).click(addPageListener);
            }
            lastBtn = '#pageBtn'+pages;
            $(nextPage).insertAfter($(lastBtn).parent());
            $("#prevPageBtn").click(goPrevPage);
            $("#nextPageBtn").click(goNextPage);
              
              $.each(jdata.events, function(i, item) {
                bgdanger = item.cancelled == 1 ? "bg-danger" : "";
                calendarColor = item.cancelled == 1 ? "text-white" : "text-muted";
                viewBtnColor = item.cancelled == 1 ? "btn-outline-light" : "btn-outline-secondary";
                html = "<div class='col-md-4'><div id='event-card' class='card mb-3'>"+
                    "<img src='"+baseURL+"uploads/"+item.event_img+"' class='card-img-top' alt='immagine di un concerto'>"+
                    "<div class='card-body'>"+
                      "<h5 class='card-title'>"+item.title+"</h5>"+
                      "<small class='text-muted'><i class='fa fa-map-marker'></i> "+item.venue+" ("+item.city+")</small>"+
                      "<p class='card-text'>"+item.description+"</p>"+
                    "</div>"+
                    "<div class='card-footer d-flex justify-content-between align-items-center "+bgdanger+"'>"+
                    "<small class='"+calendarColor+"'><i class='fa fa-calendar-o'></i> "+new Date(item.date).toDateString()+"</small>"+
                    "<a href='"+baseURL+"events/"+item.event_id+"' class='btn btn-sm "+viewBtnColor+"'>View</a>"+
                    "</div></div></div>";
                    $('#events-container .row').append(html);
              });
            } else {
              $('#events-container .row').append("<div class='col-12'><p>No event found</p></div>");
            }
          } else {
            $('#events-container .row').append("<div class='col-12'><p>No event found</p></div>");
          }
        }
    });
  }

  function addPageListener(event) {
    event.preventDefault();
    $('.pagination li').removeClass('active');
    $(this).parent().addClass('active');
    loadEvents();
  }

  function goNextPage(event) {
    event.preventDefault();
    currentIndex = $('.pagination li.active');
    currentIndex.removeClass('active');
    currentIndex.next().addClass('active');
    loadEvents();
  }

  function goPrevPage() {
    event.preventDefault();
    currentIndex = $('.pagination li.active');
    currentIndex.removeClass('active');
    currentIndex.prev().addClass('active');
    loadEvents();
  }
});

