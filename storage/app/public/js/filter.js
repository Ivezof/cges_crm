let yesterday = document.getElementById('yesterday');
let today = document.getElementById('today');
let week = document.getElementById('week');
let month = document.getElementById('month');
let period = document.getElementById('period');
let filter_elem = document.getElementsByClassName('filter')[0];
let period_text = document.getElementsByClassName('period-text')[0];

let stat_complete_count = document.getElementById('stats-complete');
let stat_canceled_count = document.getElementById('stats-canceled');
let stat_active_count = document.getElementById('stats-active');

let dayunix = 86400;
let weekunix = dayunix * 7;
let monthunix = dayunix * 31;

let timezone = 10800;

let api_point = 'api/';



async function filter(fromdate, todate) {
    console.log(api_point)
    fromdate = fromdate + timezone;
    todate = todate + timezone;
    let method = 'getStats'
    let params = `from=${fromdate}&to=${todate}`
    let data = await fetch(api_point + method + "?" + params).then(data => {
        return data.json();
    })
    console.log(data)

    stat_complete_count.innerHTML = data['completed']
    stat_canceled_count.innerHTML = data['canceled']
    stat_active_count.innerHTML = data['active']
}


function init() {

    let period_texts;
    let today_unix = new Date().setHours(0, 0, 0, 0);
    today_unix = Math.floor(today_unix / 1000);
    filter(today_unix, today_unix + dayunix, stat_complete_count, 'completed').then();
    period_texts = document.getElementsByClassName('period-text');
    [].forEach.call(period_texts, function (el) {
        el.innerHTML = 'за сегодня'
    })
    filter_elem.onclick = (event) => {
        let target = event.target;
        switch (target.id) {
            case 'yesterday':
                document.getElementsByClassName('active-filter')[0].classList.remove('active-filter');
                target.classList.add('active-filter');
                filter(today_unix - dayunix, today_unix).then();
                period_texts = document.getElementsByClassName('period-text');
                [].forEach.call(period_texts, function (el) {
                    el.innerHTML = 'за вчера'
                })
                break;
            case 'today':
                document.getElementsByClassName('active-filter')[0].classList.remove('active-filter');
                target.classList.add('active-filter');
                filter(today_unix, today_unix + dayunix).then();
                period_texts = document.getElementsByClassName('period-text');
                [].forEach.call(period_texts, function (el) {
                    el.innerHTML = 'за сегодня'
                })
                break;
            case 'week':
                document.getElementsByClassName('active-filter')[0].classList.remove('active-filter');
                target.classList.add('active-filter');
                filter(today_unix - weekunix, today_unix).then();
                period_texts = document.getElementsByClassName('period-text');
                [].forEach.call(period_texts, function (el) {
                    el.innerHTML = 'за неделю'
                })
                break;
            case 'month':
                document.getElementsByClassName('active-filter')[0].classList.remove('active-filter');
                target.classList.add('active-filter');
                filter(today_unix - monthunix, today_unix).then();
                period_texts = document.getElementsByClassName('period-text');
                [].forEach.call(period_texts, function (el) {
                    el.innerHTML = 'за месяц'
                })
                break;
        }
    };
}


init();

