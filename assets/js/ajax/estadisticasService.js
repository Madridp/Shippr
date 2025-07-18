// We need to listen to 4 buttons
// Month, 3 months, 6 months and 1 year of data
var single_month, three_months, six_months, single_year;

// We need a placeholder for our graph
var element = 'dashboard-reportes-morris';
var graph_wrapper = $('.'+element+'');

// We need data object to bring all of our data
var graph;
var data;

// Our main function
var fetch = function () {
  if(graph_wrapper.length !== 0){

    var data = null; // Data response from ajax

    $.ajax({
      url: 'ajax/estadisticas',
      dataType: 'JSON',
      type : 'POST',
      data: 
      {
        hook: 'ss_ajax_hook',
      }
    }).done((res) => {
      if(res.status === 200){
        if(res.reportes.data !== null){
          draw_bar_table(graph_wrapper , 'xkey' , ['ykeys'] , ['Reportes'] , res.reportes.data);
        }
        if(res.anticipos.data !== null){
          draw_bar_table($('.dashboard-anticipos-morris') , 'xkey' , ['ykeys'] , ['Anticipos'] , res.anticipos.data);
        }
        if(res.clientes.data !== null){
          draw_bar_table($('.dashboard-clientes-morris') , 'xkey' , ['ykeys'] , ['Clientes'] , res.clientes.data);
        }
        if(res.equipos.data !== null){
          draw_bar_table($('.dashboard-equipos-morris') , 'xkey' , ['ykeys'] , ['Equipos'] , res.equipos.data);
        }
      }
    }).fail((err) => {
      console.log(err);
      return false;
    });
  }
}();


// To draw a Morris bar table
function draw_bar_table(element , xkey, ykeys , labels , data)
{

  Morris.Bar({
    element: element,
    data: data,
    xkey: xkey,
    ykeys: ykeys,
    labels: labels,
    barColors: ['#007BFF'],
    barRatio: 0.4,
    xLabelAngle: 45,
    hideHover: 'auto'
  });
  return true;

}

// To draw a Morris donut table
function draw_donut_table(element , data , colors)
{

  Morris.Donut({
    element: element,
    data: data,
    colors: colors,
    formatter: function (y) {
      return y + "%"
    }
  });
  
  return true;

}