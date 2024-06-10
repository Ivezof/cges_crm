google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawChart)
let months = [
    'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
    'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря',
];
async function getData() {
    let today_unix = new Date().setHours(0, 0, 0, 0) / 1000;
    let fromday_unix = today_unix - monthunix;
    let method = 'getOrders'
    let params = `from=${fromday_unix}&to=${today_unix}`;
    let data = await fetch(api_point + method + "?" + params).then(data => {
        return data.json();
    });
    let stats = {};
    console.log(data);
    [].forEach.call((data), function (order) {
        console.log(order['created_at'])
        let month = months[Number(order['created_at'].split('-')[1].split('-')[0])];
        let day = Number(order['created_at'].split('-')[2].split('T')[0]);
        let profit = order['budget'] - order['spent'];
        let date_str = day.toString() + ' ' + month;
        if (date_str in stats) {
            stats[day.toString() + ' ' + month] += profit
        } else {
            stats[day.toString() + ' ' + month] = profit
        }
    });
    return stats;
}
async function drawChart() {
    let arrayToData = [['Дата', 'Прибыль']];
    let dataServer = await getData();
    console.log('server: ', dataServer);
    if (Object.keys(dataServer).length === 0) {
        return
    }

    for (let key in dataServer) {
        arrayToData.push([key, dataServer[key]]);
    }
    console.log(arrayToData)
    let data = google.visualization.arrayToDataTable(arrayToData);

    let options = {
        'title': 'Прибыль компании',
        titleTextStyle: {
            color: "#ffffff",
            fontSize: 20,
            bold: true,
        },
        colors: ['#47B143'],
        legend: {
            textStyle: {
                color: 'white',
                fontSize: 16,
                bold: true
            }
        },
        hAxis: {
            textStyle: {
                color: 'white'
            },


        },
        vAxis: {
            minValue: 0,
            textStyle: {
                color: 'white'
            },
            gridlines: {
                color: '#436480'
            },
        },
        backgroundColor: '#00467F',
    };

    let chart = new google.visualization.AreaChart(document.getElementById("chart_div"));
    chart.draw(data, options);
}
