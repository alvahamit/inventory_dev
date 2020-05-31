// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    //labels: ["Margarine", "Cake Mix", "Cake Gel", "Whip Cream"],
    labels: [],
    datasets: [{
      //data: [250, 150, 50, 230],
      data: [],
      //backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#ffbb33'],
      backgroundColor: [],
      //hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#FF8800'],
      hoverBackgroundColor: [],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        // this callback is used to create the tooltip label
        label: function(tooltipItem, data) {
          // get the data label and data value to display
          // convert the data value to local string so it uses a comma seperated number
          var dataLabel = data.labels[tooltipItem.index];
          var value = ': Tk. ' + number_format((data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index])/1000)+' K';
          // make this isn't a multi-line label (e.g. [["label 1 - line 1, "line 2, ], [etc...]])
          if (Chart.helpers.isArray(dataLabel)) {
            // show value on first line of multiline label
            // need to clone because we are changing the value
            dataLabel = dataLabel.slice();
            dataLabel[0] += value;
          } else {
            dataLabel += value;
          }
          // return the text to display on the tooltip
          return dataLabel;
        }
      }
    },
    legend: {
      display: true,
      labels: {
          fontSize: 10,
          boxWidth: 10,
      },
      position: 'bottom',
      padding: 20,
    },
    cutoutPercentage: 80,
  },
});
