var serverId = $("#server_id").attr("value");
var baseUrl = "../api";
var apiUrl = baseUrl+"/get/"+serverId+"/";

function addGraphs(services)
{
    for (i in services) {
        document.getElementById('graphs').innerHTML += '<div class="col-md-6">'+
        '<div class="text-center">'+
        '<p class="label label-info">'+services[i]['sub']+'</p></div>'+
        '<div id="graph_'+services[i]['name']+'"></div></div>';
    }
            
    for (i in services) {
        loadDygraph(services[i]['name'], services[i]['percentages']);
    }
}
        
function loadDygraph(name, returnPercentage)
{
    new Dygraph(
        document.getElementById("graph_"+name),
        apiUrl+name,
        {
            axes: {
                y: {
                    axisLabelFormatter: function (y) {
                        return returnPercentage == true ? Math.round(y*10)/10 + '%' : Math.round(y*10)/10 + '';
                    }
                }
            }
        }
    );
}
        
    $(document).ready(function () {
    
        $.ajax({
            url : baseUrl+'/graphServices',
            type : 'GET',
            cache : false,
            success : function (data) {
                if (data instanceof Array) {
                    addGraphs(data);
                }
            }
        });
    });
