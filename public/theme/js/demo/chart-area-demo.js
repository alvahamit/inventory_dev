// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

/*
 * Origin Edited By: Alvah Amit Halder
 * Note: Reference this chart in your dash blade by variable "myBarChart".
 */
var canvas = document.getElementById("myAreaChart");
var ctx = canvas.getContext('2d');

// Global Options:
Chart.defaults.global.defaultFontColor = 'black';
Chart.defaults.global.defaultFontSize = 16;
var data = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
        {
            label: "Orders",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(0, 128, 0, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(0, 128, 0, 1)",
            pointBorderColor: "rgba(0, 128, 0, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(0, 128, 0, 1)",
            pointHoverBorderColor: "rgba(0, 128, 0, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            // notice the gap in the data and the spanGaps: true
            data: [200, 205, 212, 250, 255, 100, 120, 110, 60, 55, 30, 78],
            spanGaps: true,
        },
        {
            label: "Invoices",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(255, 255, 0, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(255, 255, 0, 1)",
            pointBorderColor: "rgba(255, 255, 0, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(255, 255, 0, 1)",
            pointHoverBorderColor: "rgba(255, 255, 0, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            // notice the gap in the data and the spanGaps: false
            data: [100, 103, 106, 125, 150, 80, 100, 90, 120, 60, 85, 50],
            spanGaps: false,
        },
        {
            label: "Collections",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(255, 165, 0, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(255, 165, 0, 1)",
            pointBorderColor: "rgba(255, 165, 0, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(255, 165, 0, 1)",
            pointHoverBorderColor: "rgba(255, 165, 0, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            // notice the gap in the data and the spanGaps: false
            data: [50, 70, 150, 50, 60, 45, 98, 62, 36, 87, 36, 112],
            spanGaps: false,
        }
    ]
};

// Notice the scaleLabel at the same level as Ticks
var options = {
  maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return 'Tk.' + number_format(value/1000) +' K';
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true,
      labels: {
          fontSize: 10,
          boxWidth: 10,
      },
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': Tk.' + number_format(tooltipItem.yLabel);
        }
      }
    }
  };

// Chart declaration:
var myBarChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: options
});
