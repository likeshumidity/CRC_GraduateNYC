"use strict";

var width = 700,
    height = 1165,
    active = d3.select(null);

var neighborhoodSvg = d3.select(".map").append("svg")
    .attr("width", width)
    .attr("height", height);

var boroughSvg = d3.select(".map").append("svg")
    .attr("width", width)
    .attr("height", height);

var projection = d3.geo.mercator()
    .center([-73.94, 40.50])
    .scale(50000)
    .translate([(width) / 2, (height) / 2]);

var path = d3.geo.path()
    .projection(projection)

boroughSvg.append("rect")
    .attr("class", "background")
    .attr("width", width)
    .attr("height", height)
    .on("click", reset);

var borG = boroughSvg.append("g")

var ntaG = neighborhoodSvg.append("g")


///Range of colors based on density
var color = d3.scale.linear()
    .domain([0, 15])
    .range(["white", "black"]);

var BrooklynArray = {},
    BronxArray = {},
    QueensArray = {},
    ManhattanArray = {},
    StatenArray = {},
    TargetArray = [],
    curTarget = "All",
    GradesArray = ["Elem", "MS", "HS", "College"],
    ServicesArray = ["CR", "CM", "CT", "CP"],
    EnrollArray = ["All", "open", "limited", "closed"],
    curEnroll = "All"

var allData = {};
var curData = {};
var geoData = {};

d3.json("assets/data.json", function (error, json) {
    if (error) return console.warn(error);
    allData = json;
    for (var key in json) {
        if (json[key].Target.length != 0) {
            for (let i = 0; i < json[key].Target.length; i++) {
                if (TargetArray.indexOf(json[key].Target[i]) === -1) {
                    TargetArray.push(json[key].Target[i])
                    var option = $('<option />').val(json[key].Target[i]).text(json[key].Target[i]);
                    $("#dropDownTarget").append(option);
                }
            }
        }
    }
    setUpArrays(json)
});

var setUpArrays = function (data) {
    BrooklynArray = {}
    BronxArray = {}
    QueensArray = {}
    ManhattanArray = {}
    StatenArray = {}
    for (var key in data) {
        if (data[key].Brooklyn.length != 0) {
            for (let i = 0; i < data[key].Brooklyn.length; i++) {
                if (data[key].Brooklyn[i] in BrooklynArray) {
                    BrooklynArray[data[key].Brooklyn[i]] += 1;
                } else {
                    BrooklynArray[data[key].Brooklyn[i]] = 1;
                }
            }
        }
        if (data[key].Bronx.length != 0) {
            for (let i = 0; i < data[key].Bronx.length; i++) {
                if (data[key].Bronx[i] in BronxArray) {
                    BronxArray[data[key].Bronx[i]] += 1;
                } else {
                    BronxArray[data[key].Bronx[i]] = 1;
                }
            }
        }
        if (data[key].Queens.length != 0) {
            for (let i = 0; i < data[key].Queens.length; i++) {
                if (data[key].Queens[i] in QueensArray) {
                    QueensArray[data[key].Queens[i]] += 1;
                } else {
                    QueensArray[data[key].Queens[i]] = 1;
                }
            }
        }
        if (data[key].Manhattan.length != 0) {
            for (let i = 0; i < data[key].Manhattan.length; i++) {
                if (data[key].Manhattan[i] in ManhattanArray) {
                    ManhattanArray[data[key].Manhattan[i]] += 1;
                } else {
                    ManhattanArray[data[key].Manhattan[i]] = 1;
                }
            }
        }
        if (data[key].Staten.length != 0) {
            for (let i = 0; i < data[key].Staten.length; i++) {
                if (data[key].Staten[i] in StatenArray) {
                    StatenArray[data[key].Staten[i]] += 1;
                } else {
                    StatenArray[data[key].Staten[i]] = 1;
                }
            }
        }

    }
    updateMap();

}

var filterData = function () {
    for (var item in allData) {
        curData[item] = allData[item]
    }
    if (curTarget != "All") {
        for (var key in curData) {
            if (curData[key].Target.indexOf(curTarget) === -1) {
                delete curData[key]
            }
        }
    }
    setUpArrays(curData)
}

var updateMap = function () {
    d3.selectAll('.neighborhood').transition()
        .duration(750)
        .style("fill", function (d) {
            for (var key in window[d.properties.boroname + "Array"]) {
                if (d.properties.ntaname.indexOf(key) > -1) {
                    return color(window[d.properties.boroname + "Array"][key])
                }
            }
            return color(0)
        })
}
$('#dropDownTarget').on('change', function () {
    curTarget = $(this).val()
    console.log(curTarget)
    filterData();
});
$('#dropDownEnrollment').on('change', function () {
    console.log($(this).val())
});
$(".grades").change(function () {
    console.log($(this).val())
});
$(".service").change(function () {
    console.log($(this).val())
});



d3.json("assets/Boroughs.json", function (error, bor) {
    /* svg.insert("path", ".graticule")
         .datum(topojson.feature(nta, nta.objects.NTA))
         .attr("class", "NTA")
         .attr("d", path);*/

    borG.selectAll(".borough")
        .data(topojson.feature(bor, bor.objects.Boroughs).features)
        .enter().append("path")
        .attr("class", "borough")
        .attr("id", function (d) {
            return d.properties.boroname;
        })
        .attr("d", path)
        .on("click", clicked);
})

d3.json("assets/NTA.json", function (error, nta) {
    /* svg.insert("path", ".graticule")
         .datum(topojson.feature(nta, nta.objects.NTA))
         .attr("class", "NTA")
         .attr("d", path);*/

    console.log("LOADING")
    geoData = nta;

    ntaG.selectAll(".neighborhood")
        .data(topojson.feature(nta, nta.objects.NTA).features)
        .enter().append("path")
        .attr("class", "neighborhood")
        .attr("id", function (d) {
            return d.properties.ntaname;
        })
        .attr("d", path)
        .style("fill", function (d) {
            for (var key in window[d.properties.boroname + "Array"]) {
                if (d.properties.ntaname.indexOf(key) > -1) {
                    return color(window[d.properties.boroname + "Array"][key])
                }
            }
            return color(0)
        })
        .style('stroke-width', '.5px')
        .style("stroke", "#cecece")
        .on("click", clicked);
})


function clicked(d) {
    console.log(this)
    if (active.node() === this) return reset();
    active.classed("active", false);
    active = d3.select(this).classed("active", true);

    var bounds = path.bounds(d),
        dx = bounds[1][0] - bounds[0][0],
        dy = bounds[1][1] - bounds[0][1],
        x = (bounds[0][0] + bounds[1][0]) / 2,
        y = (bounds[0][1] + bounds[1][1]) / 2,
        scale = .9 / Math.max(dx / width, dy / height),
        translate = [width / 2 - scale * x, height / 2 - scale * y];

    borG.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")");

    ntaG.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")");
}

function reset() {
    active.classed("active", false);
    active = d3.select(null);

    borG.transition()
        .duration(750)
        .style("stroke-width", "1.5px")
        .attr("transform", "");
    ntaG.transition()
        .duration(750)
        .attr("transform", "");
}