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
    .domain([0, 60])
    .range(["white", "black"]);

var BrooklynArray = {},
    BronxArray = {},
    QueensArray = {},
    ManhattanArray = {},
    StatenArray = {},
    curTarget = "All",
    filterArray = [
        ["Brooklyn", "Bronx", "Queens", "Manhattan", "Staten Island"],
        "All",
        "All",
        ["Elementary school (K-5)", "Middle school (6-8)", "High School (9-12)", "College"],
        ["College Readiness", "College Matriculation", "College Retention", "Career Preparation", "Technical assistance to community based organizations", "A network for convening CBOs or programs that work on similar issues or work with overlapping sets of students", "Professional development for college access and success staff", "Training or awareness for students", "Research connected to this field for practitioner use", "Advocacy on behalf of the sector or segments of it", "Online resources for students and/or staff"]
    ]

var allData = {};
var curData = {};
var geoData = {};

d3.json("assets/dataNew.json", function (error, json) {
    if (error) return console.warn(error);
    allData = json;
    setUpArrays(json)
});

var setUpArrays = function (data) {
    BrooklynArray = {}
    BronxArray = {}
    QueensArray = {}
    ManhattanArray = {}
    StatenArray = {}

    for (var key in data) {
        if (data[key].borroughs.indexOf("Brooklyn") >= -1) {
            for (let i = 0; i < data[key].neighborhoods.length; i++) {
                if (data[key].neighborhoods[i].indexOf("Brooklyn") > -1) {
                    if (data[key].neighborhoods[i] in BrooklynArray) {
                        BrooklynArray[data[key].neighborhoods[i]] += 1;
                    } else {
                        BrooklynArray[data[key].neighborhoods[i]] = 1;
                    }
                }
            }
        }

        if (data[key].borroughs.indexOf("Queens") >= -1) {
            for (let i = 0; i < data[key].neighborhoods.length; i++) {
                if (data[key].neighborhoods[i].indexOf("Queens") > -1) {
                    if (data[key].neighborhoods[i] in QueensArray) {
                        QueensArray[data[key].neighborhoods[i]] += 1;
                    } else {
                        QueensArray[data[key].neighborhoods[i]] = 1;
                    }
                }
            }
        }

        if (data[key].borroughs.indexOf("Bronx") >= -1) {
            for (let i = 0; i < data[key].neighborhoods.length; i++) {
                if (data[key].neighborhoods[i].indexOf("Bronx") > -1) {
                    if (data[key].neighborhoods[i] in BronxArray) {
                        BronxArray[data[key].neighborhoods[i]] += 1;
                    } else {
                        BronxArray[data[key].neighborhoods[i]] = 1;
                    }
                }
            }
        }

        if (data[key].borroughs.indexOf("Staten") >= -1) {
            for (let i = 0; i < data[key].neighborhoods.length; i++) {
                if (data[key].neighborhoods[i].indexOf("Staten") > -1) {
                    if (data[key].neighborhoods[i] in StatenArray) {
                        StatenArray[data[key].neighborhoods[i]] += 1;
                    } else {
                        StatenArray[data[key].neighborhoods[i]] = 1;
                    }
                }
            }
        }

        if (data[key].borroughs.indexOf("Manhattan") >= -1) {
            for (let i = 0; i < data[key].neighborhoods.length; i++) {
                if (data[key].neighborhoods[i].indexOf("Manhattan") > -1) {
                    if (data[key].neighborhoods[i] in ManhattanArray) {
                        ManhattanArray[data[key].neighborhoods[i]] += 1;
                    } else {
                        ManhattanArray[data[key].neighborhoods[i]] = 1;
                    }
                }
            }
        }
    }

    updateMap();

}

var filterData = function (program) {
    var check = true;

    //check boroughs
    var neighbCheck = false;
    for (let i = 0; i < filterArray[0].length; i++) {
        if (program.borroughs.indexOf(filterArray[0][i]) > -1) {
            neighbCheck = true;
        }
    }
    if (neighbCheck === false) {
        return false;
    }

    //check open status
    var openCheck = false;
    if (filterArray[1] === "All" || program.accepting_students.indexOf(filterArray[1]) > -1) {
        openCheck = 'true';
    }
    if (openCheck === false) {
        return false;
    }

    //check target population
    var targetCheck = false;
    if (filterArray[2] === "All" || program.target_population.indexOf(filterArray[2]) > -1) {
        targetCheck = 'true';
    }
    if (targetCheck === false) {
        return false;
    }

    //check grades
    var gradesCheck = false;
    for (let i = 0; i < filterArray[3].length; i++) {
        if (program.grades.indexOf(filterArray[3][i]) > -1) {
            gradesCheck = true;
        }
    }
    if (gradesCheck === false) {
        return false;
    }

    //check services
    var serviceCheck = false;
    for (let i = 0; i < filterArray[4].length; i++) {
        if (program.services.indexOf(filterArray[4][i]) > -1) {
            serviceCheck = true;
        }
    }
    if (serviceCheck === false) {
        return false;
    }

    return check;

}
var createFilteredObj = function (data) {
    var filterObj = {};
    for (var key in data) {
        if (filterData(data[key])) {
            filterObj[key] = data[key]
        }
    }
    return filterObj
}

var updateMap = function () {
    d3.selectAll('.neighborhood').transition()
        .duration(750)
        .style("fill", function (d) {
            for (var key in window[d.properties.boroname + "Array"]) {
                var neighb = key.split(" - ")[1]
                if (d.properties.ntaname.indexOf(neighb) > -1) {
                     d.density = window[d.properties.boroname + "Array"][key];
                    return color(window[d.properties.boroname + "Array"][key])
                }
            }
            return color(0)
        })
}


$('#gnsm-burroughs').on('change', function () {

    filterArray[0] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$('#gnsm-open-status').on('change', function () {

    filterArray[1] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$('#gnsm-target-population').on('change', function () {

    filterArray[2] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$("#gnsm-grades-served").change(function () {

    filterArray[3] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$("#gnsm-services").change(function () {

    filterArray[4] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});



d3.json("assets/Boroughs.json", function (error, bor) {

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
                var neighb = key.split(" - ")[1]
                if (d.properties.ntaname.indexOf(neighb) > -1) {
                    d.density = window[d.properties.boroname + "Array"][key];
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

    if (active.node() === this) return reset();
    active.classed("active", false);
    active = d3.select(this).classed("active", true);

    var bounds = path.bounds(d),
        dx = bounds[1][0] - bounds[0][0],
        dy = bounds[1][1] - bounds[0][1],
        x = (bounds[0][0] + bounds[1][0]) / 2,
        y = (bounds[0][1] + bounds[1][1]) / 2,
        scale = .5 / Math.max(dx / width, dy / height),
        translate = [width / 2 - scale * x, height / 2 - scale * y];

    borG.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")")

    ntaG.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")")
    
    ntaG.append("svg:title")
        .text("hi")
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