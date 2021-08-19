// Colocar una nueva configuración default
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Pendiente de autorización", "Entregada pero pendiente de Verificación", "Autorizadas pendiente de Factura", "Rechazadas", "Finalizadas", "Canceladas"],
        datasets: [{            
            data: [sPAA, sAPV, sAPF, sR, sF, sC],
            backgroundColor: ['#f1c40f', '#00b59a', '#079543', '#c0392b', '#8e44ad', '#95a5a6'],
            hoverBackgroundColor: ['#b48f00', '#007f67', '#006112', '#830000', '#580c78', '#627172'],
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
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
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
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});