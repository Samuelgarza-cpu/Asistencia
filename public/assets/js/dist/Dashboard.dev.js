"use strict";

// Colocar una nueva configuración default
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796'; // Pie Chart Example

var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Pendiente de autorización", "Entregada pero pendiente de autorización", "Rechazadas", "Autorizadas pendiente de entrega", "Finalizadas"],
    datasets: [{
      data: [sPA, sEPA, sR, sA, sF],
      backgroundColor: ['#f6c23e', '#36b9cc', '#e74a3b', '#1cc88a', '#858796'],
      hoverBackgroundColor: ['#faca53', '#3ed7ed', '#fa6051', '#33ffb6', '#cccedd'],
      hoverBorderColor: "rgba(234, 236, 244, 1)"
    }]
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
      caretPadding: 10
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80
  }
});
var ctx2 = document.getElementById("myPieChart2");
var myPieChart2 = new Chart(ctx2, {
  type: 'pie',
  data: {
    labels: ["Trabajo Social", "Responsiva", "Foliado"],
    datasets: [{
      data: [sT1, sT2, sT3],
      backgroundColor: ['#007bff', '#28a745', '#ffc107'],
      hoverBackgroundColor: ['#8abaee', '#54d8a8', '#fdce56'],
      hoverBorderColor: "rgba(234, 236, 244, 1)"
    }]
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
      caretPadding: 10
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80
  }
});