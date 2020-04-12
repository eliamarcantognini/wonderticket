function loadChart(data){
  console.log(data);
  var ctx = document.getElementById('chart');
  var mychart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: data.x.flat(),
      datasets: [{
        label: "Tickets Sold",
        data: data.y.flat(),
        borderColor: 'rgba(255, 170, 0, 1)',
        borderWidth: 1,
        backgroundColor: 'rgba(255, 170, 0, 0.5)'
      }],
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            max: Math.max.apply(this, data.y) + 1,
            stepSize: 5
          }
        }]
      }
    }
  });
}

$(document).ready(function (){
  var tmpJsonData = "";
  URL = window.location.origin+"/wonderticket/public/users/chart";
  $.ajax({
      type: "GET",
      url: URL,
      success: function(data) {
        tmpJsonData = data;
        jdata = JSON.parse(data);
        loadChart(jdata);
      }
  });
  setInterval(function() {
      $.ajax({
          type: "GET",
          url: URL,
          success: function(data) {
            if (!(tmpJsonData == data)) {
              jdata = JSON.parse(data);
              loadChart(jdata);
            }
            tmpJsonData = data;
          }
      });
  }, 2000);
});
