// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
const myValue = document.querySelector('script[data-value]').getAttribute('data-value').split(',');

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["รอตรวจสอบ", "อนุมัติ", "ไม่อนุมัติ",],
    datasets: [{
      data: [myValue[0], myValue[1], myValue[2],],
      backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b',],
      hoverBackgroundColor: ['#9f8546', '#17a673', '#994b44',],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
