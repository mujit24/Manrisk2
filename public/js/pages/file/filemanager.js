$(document).ready(function(){
    var chart = c3.generate({
        bindto: '#chart-area', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['pendapatan', $pendapatanPerBulanArray],
                ['cashout', $cashOutPerBulanArray]
            ],
            type: 'area', // default type of chart
            colors: {
                'pendapatan': Iconic.colors["theme-cyan1"],
                'cashout': Iconic.colors["theme-cyan2"]
            },
            names: {
                // name of each serie
                'pendapatan': 'Pendapatan',
                'cashout': 'Cashout'
            }
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul','Ags','Sept','Oct','Nov','Dec']
            },
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        },
    });
});