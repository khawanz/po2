$(function() {

    // Item - item yang diorder
    Morris.Area({
        element: 'morris-area-chart',
        data: dataSelling,
        xkey: 'period',
        ykeys: itemsSelling,
        labels: itemsSelling,
        pointSize: 2,
        hideHover: 'auto',
        resize: true,
        pointFillColors: ['#ffffff'],
        pointStrokeColors: ['black'],
        lineColors: ['red', 'blue', 'green', 'blue', 'grey', 'black']
    });
	
    // Item - item yang dibeli
    Morris.Area({
        element: 'morris-area2-chart',
        data: dataBuying,
        xkey: 'period',
        ykeys: itemsBuying,
        labels: itemsBuying,
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "PT PLN Persero",
            value: 12
        }, {
            label: "PT Pertamina Tbk",
            value: 30
        }, {
            label: "PT Peruri Persero",
            value: 20
        }, {
            label: "PT Pertamina Tbk",
            value: 30
        }, {
            label: "PT Peruri Persero",
            value: 20
        }, {
            label: "PT Pertamina Tbk",
            value: 30
        }, {
            label: "PT Peruri Persero",
            value: 20
        }],
        resize: true
    });
});
