
function refreshBtns() {
    $("#btnPrevPeriod").attr('disabled', true);
    $("#btnNextPeriod").attr('disabled', true);

    if ($('#ddlPeriod option:selected').prev().length > 0) {
        $("#btnPrevPeriod").attr('disabled', false);
    }

    if ($('#ddlPeriod option:selected').next().length > 0) {
        $("#btnNextPeriod").attr('disabled', false);
    }
}

function refreshDatatable() {
    dataTable.ajax.url('{{ path('history_list') }}/' + $("#ddlPeriod option:selected").text()).load();
    updateChart();
}

function selectNext(ddlField) {
    $('#ddlPeriod option:selected')
        .prop("selected", false)
        .next()
        .prop("selected", true);
    refreshBtns();
    refreshDatatable();
}

function selectPrev(ddlField) {
    $('#ddlPeriod option:selected')
        .prop("selected", false)
        .prev()
        .prop("selected", true);
    refreshDatatable();
}

function updateChart(year, month) {
    $(".form-control,.btn").attr('disabled', true);
    $.ajax({
        url: "{{ path('history_listcat') }}/" + $("#ddlPeriod option:selected").text(),
        type: "GET",
        dataType: "json",
        success: function(data) {
            if(chart.get('expenses')) {
                chart.get('expenses').remove();
            }
            data.data.map(function(val) { val.y = Number.parseFloat(val.y); });
            chart.addSeries(data);
            $(".form-control,.btn").attr('disabled', false);
            refreshBtns();
        },
        cache: false
    });
}

$(function(){
    monthList.map(function(value) {
        $("#ddlPeriod").append($("<option />").val(value.id).text(value.text).prop('selected', current===value.text));
    });

    dataTable = $("#historyTable").DataTable( {
        "ajax": "{{ path('history_list') }}/" + $("#ddlPeriod option:selected").text(),
        "columns": [
            { "data": "date" },
            { "data": "nom" },
            { "data": "nomCategorie" },
            { "data": "nomMoyen" },
            { "data": "valeur" },
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": -1,
        "order": [[ 0, "desc" ]],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 4 ).footer() ).html(
                total.toFixed(2)
            );
        }
    });
    var options = {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Répartition'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.2f} ({point.percentage:.1f}%)</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: []
    };

    chart = Highcharts.chart('historyChart', options);

    /*chart.addSeries({
        name: 'Dépenses',
        colorByPoint: true,
        data: [{"y":1370.112811258,"0":"1370.112811258","name":"ALIMENTATION","1":"ALIMENTATION"},{"y":1113.18720530702,"0":"-1113.18720530702","name":"JEUX VIDEO","1":"JEUX VIDEO"},{"y":547.766562894462,"0":"547.766562894462","name":"VOYAGES","1":"VOYAGES"},{"y":993.446146178691,"0":"-993.446146178691","name":"DIVERS","1":"DIVERS"},{"y":661.058916703616,"0":"-661.058916703616","name":"RETRAITS CB","1":"RETRAITS CB"},{"y":699.435063155761,"0":"699.435063155761","name":"SANTE","1":"SANTE"},{"y":27.4729380241355,"0":"27.4729380241355","name":"RESTAURANT","1":"RESTAURANT"}]});
    */
    updateChart();
    refreshBtns();

    $('#example').DataTable();
    $("#ddlPeriod").change(function() {
        refreshBtns();
        refreshDatatable();
    });

    $("#btnPrevPeriod").click(function() {
        selectPrev($("#ddlPeriod"));
    });

    $("#btnNextPeriod").click(function() {
        selectNext($("#ddlPeriod"));
    });
});
