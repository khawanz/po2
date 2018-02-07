
$(document).ready(function(){    
    
    // change order bar chart 
    $('#select-order-bar').change(function(){
        var url = '../controller/api/getOrderBar.php';
        $.ajax({
            method: "POST",
            url: url,
            dataType: 'json',
            data: {
                period: this.value
            }
        })
        .done(function (reply) {
            $('#order-bar-chart').html('');
            Morris.Bar({
                element: 'order-bar-chart',
                data: reply.data,
                xkey: 'y',
                ykeys: reply.suppliers,
                labels: reply.suppliers,
                hideHover: 'auto',
                resize: true
            });
        });
    });
    
    $('#select-order-bar').trigger('change');
    
    // change item area chart 
    $('#select-item-area').change(function(){
        var url = '../controller/api/getItemArea.php';
        $.ajax({
            method: "POST",
            url: url,
            dataType: 'json',
            data: {
                period: this.value
            }
        })
        .done(function (reply) {
            $('#item-area-chart').html('');
            Morris.Area({
                element: 'item-area-chart',
                data: reply.data,
                xkey: 'period',
                ykeys: reply.items,
                labels: reply.items,
                pointSize: 2,
                hideHover: 'auto',
                resize: true,
                parseTime: false
            });
        });
    });
    
    $('#select-item-area').trigger('change');
    
    // change inventory area chart 
    $('#select-inventory-area').change(function(){console.log('inven change');
        var url = '../controller/api/getInventoryArea.php';
        $.ajax({
            method: "POST",
            url: url,
            dataType: 'json',
            data: {
                period: this.value
            }
        })
        .done(function (reply) {console.log('inventory',reply);
            $('#inventory-area-chart').html('');
            Morris.Area({
                element: 'inventory-area-chart',
                data: reply.data,
                xkey: 'period',
                ykeys: reply.items,
                labels: reply.items,
                pointSize: 2,
                hideHover: 'auto',
                resize: true,
                parseTime: false
            });
        });
    });
    
    $('#select-inventory-area').trigger('change');
    
    displayDonut();
        
    function displayDonut() {
        Morris.Donut({
            element: 'donut-chart',
            data: totalDayData,
            resize: true
        });
    }
});