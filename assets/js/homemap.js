/* 
 * Map on Home Page
 * with D3.js / Topojson 
 */

/*
var projection = d3.geo.albers()
    .center([0, 50])
    .rotate([-10, 0])
    .parallels([50, 60])
    .scale(800 * 1)
    .translate([width / 2, height / 2]);
*/
   


var projection, pathl, svg, map_option, DEVICE, ww;
var tooltip = d3.select("#tooltip").classed("hidden", true),
    countrydiv = d3.select("#countrydiv"),
    legenda = d3.select("#legenda");

function loadmap(){

    ww = $(window).width();
    
    if(ww>=1200){
        DEVICE ='lg';
        map_option = {
            width: 320,
            height: 280,
            scale : 450, 
            center: [55,25],
            threshold: 180
        };

    } else if(ww>=992){
        DEVICE = 'md';
        map_option = {
            /*width: 200,
            height: 230,
            scale : 320, 
            center: [70,0],
            threshold: 180*/
            width: 260,
            height: 270,
            scale : 390, 
            center: [61,15],
            threshold: 180
        };

    } else if(ww >= 768){
        DEVICE = 'sm';
        map_option = {
            width: 260,
            height: 290,
            scale : 390, 
            center: [61,15],
            threshold: 180
        };
    } else{
        DEVICE = 'xs';
        map_option = {
            width: 290,
            height: 280,
            scale : 390, 
            center: [61,15],
            threshold: 180
        };
    }
    
    
    projection = d3.geo.conicEqualArea()
        .parallels([29.5,45.5])
        .rotate([-4,0])
        .center(map_option.center)
        .scale(map_option.scale);

    path = d3.geo.path()
        .projection(projection);

    d3.selectAll("#map svg").remove();
    
    // resize the map
    d3.select("#map")
        .attr("width",map_option. width)
        .attr("height", map_option.height);

    // resize the path
    svg = d3.select("#map").append("svg")
        .attr("width",map_option. width)
        .attr("height", map_option.height);

    var map_path = "assets/data/eu.json";

    d3.json(map_path, function(error, eu) {

      svg.append("path")
          .datum(topojson.feature(eu, eu.objects.subunits))
          .attr("d", path);

      svg.selectAll(".subunit")
            .data(topojson.feature(eu, eu.objects.subunits).features)
            .enter().append("path")
            .attr("class", function(d) { return "subunit " + d.id; })
            .attr("title", function(d) { return "subunit " + d.properties.name; })
            .attr("d", path)
            .on("mouseover", function(d,i) {
                tooltip.classed("hidden", false);
                //countrydiv.text(d.properties.name);
                if(d.properties.eu28 == 1){
                    var _html = tooltip_html(d.properties);
                    countrydiv.html(_html);
                }
                else{
                    tooltip.classed("hidden", true);
                }
            })
            .on("mouseout", function(d) {
                tooltip.classed("hidden", true);
            })
            .on("click", function(d,i) {
                if(isMobile.any()===null && d.properties.eu28 == 1){
                    window.location = 'country/' + d.properties.abbr;
                }

            });
            
     });
    
     svg.on("mousemove", function(e) {
            // update tooltip position
            var dist = $('#tooltip').width() + 20;
            if(d3.event.pageX > map_option.threshold) {
                tooltip.style("top", (d3.event.pageY-10)+"px").style("left",(d3.event.pageX-dist)+"px");
            }
            else{
                tooltip.style("top", (d3.event.pageY-10)+"px").style("left",(d3.event.pageX+10)+"px");
            }
            return true;
        });

}

function tooltip_html(o){
    
    if(typeof _cdata.data[o.abbr] == 'undefined'){
        return '';
    }
    
    var html = '<h4>' + o.name + "</h4>";
    
    var data = _cdata.data[o.abbr];
    
    var perc = _cdata.comp[o.abbr];
    
    for(i in data){
        html+="<div class=\"srow\">";
        html+="<div class=\"ssx\">"+data[i]['area']+"</div><div class=\"ddx color-" + data[i]['color'] + "\"></div>";
        html+="</div>";
    }
    
    html+="<div class=\"srow spacer\"><hr></div>";
    html+="<div class=\"srow percentage\"><div class=\"ssx\">% of data completed</div><div class=\"ddx2\">" + perc + "</div>";
    
    return html;
}

// exec the script
d3.select(window).on('resize', loadmap); 
loadmap();
