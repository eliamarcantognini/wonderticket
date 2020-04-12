function loadCharts(x, y, c, i) {
    var ctx = document.getElementById('myChart'+c);
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: x.flat(),
            datasets: [{
                label: "" + i,
                data: y.flat(),
                borderColor: "#0288d1",
            }]
        }, options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: Math.max.apply(this, y) + 1,
                        stepSize: 1
                    }
                }]
            }
        }
    });
}

function loadNotificationsChart(alerts, broadcasts, c, i) {
    data = [alerts.y.flat()[0],broadcasts.y.flat()[0]];
    var ctx = document.getElementById('myChart'+c);
    var mychart = new Chart(ctx, {
        type: 'bar',
            data: {
            labels: ["Alert","Broadcast"],
            datasets: [
                {
                backgroundColor: ["#0288d1", "#ffaa00"],
                data: data
                }
            ]
            }, options: {
                legend: { display: false },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: Math.max(alerts.y[0], broadcasts.y[0]) + 1,
                            stepSize: 1
                        }
                    }]
                }
            }
      });
}

function ajaxCharts() {
    URL = window.location.origin+"/wonderticket/public/admin/charts";
    $.ajax({
        type: "GET",
        url: URL,
        success: function(data) {
            jdata = JSON.parse(data);
            c = 1;
            $.each(jdata, function(i, item) {
                if (!(i=='notifications')) {
                    loadCharts(item.x, item.y, c++, i);
                } else {
                    loadNotificationsChart(item.alerts, item.broadcasts, c++, i);
                }
            });
        }
    });
}


$(document).ready(function() {
    var tmpJsonData = "";
    URL = window.location.origin+"/wonderticket/public/admin/charts";
    $.ajax({ 
        type: "GET",   
        url: URL,   
        success: function(data) {
            tmpJsonData = data;
        }
    });
    ajaxCharts();
    setInterval(function() {
        $.ajax({ 
            type: "GET",   
            url: URL,   
            success: function(data) {
                if (!(tmpJsonData == data)) {
                    jdata = JSON.parse(data);
                    c = 1;
                    $.each(jdata, function(i, item) {
                        if (!(i=='notifications')) {
                            loadCharts(item.x, item.y, c++, i);
                        } else {
                            loadNotificationsChart(item.alerts, item.broadcasts, c++, i);
                        }
                    });
                }
                tmpJsonData = data; 
            }
        });
    }, 2000);

});