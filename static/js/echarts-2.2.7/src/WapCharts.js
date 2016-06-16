

function DrawPie(data, id, name) {
    var option = ECharts.Pie(data, name);
    Draw(option, id);

}

function DrawPie2(data, id, name) {
    var option = ECharts.Pie2(data, name);
    Draw(option, id);

}

function DrawBars(data, id, name, is_stack, showarea, chart_type) {
    var option = ECharts.Bars(data, name, is_stack, showarea, chart_type);
    Draw(option, id);

}


function DrawGauge(data, id, name) {
    var option = ECharts.Gauge(data, name);
    Draw(option, id);

}




function Draw(_option, id) {
    var option = _option;
    var container = document.getElementById(id);
    opt = ECharts.ChartConfig(container, option);
    ECharts.Charts.RenderChart(opt);
}