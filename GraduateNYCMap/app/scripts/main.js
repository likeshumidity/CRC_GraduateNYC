"use strict";

var GETURIRequest = {};

var width = 700,
    height = 1165,
    active = d3.select(null);

var tooltip = d3.select("body")
    .append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

var boroughSvg = d3.select(".map").append("svg")
    .attr("width", width)
    .attr("height", height);

var neighborhoodSvg = d3.select(".map").append("svg")
    .attr("width", width)
    .attr("height", height)
    .style("pointer-events", 'none');

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
    .range(["white", "#2F5C61"]);

var BrooklynArray = {},
    BronxArray = {},
    QueensArray = {},
    ManhattanArray = {},
    StatenArray = {},
    curTarget = "All",
    parametersJSON = {},
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

//d3.json("assets/dataNew.json", function (error, json) { //use this line if you can't see any data. 
d3.json("http://54.174.151.164/GraduateNYC/?crc-json=all_listings", function (error, json) {
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
        if (data[key].boroughs.indexOf("Brooklyn") >= -1) {
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

        if (data[key].boroughs.indexOf("Queens") >= -1) {
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

        if (data[key].boroughs.indexOf("Bronx") >= -1) {
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

        if (data[key].boroughs.indexOf("Staten") >= -1) {
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

        if (data[key].boroughs.indexOf("Manhattan") >= -1) {
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
        if (program.boroughs.indexOf(filterArray[0][i]) > -1) {
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


$('#gnsm-boroughs').on('change', function () {

    parametersJSON.boroughs = $(this).val();
    filterArray[0] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$('#gnsm-open-status').on('change', function () {

    parametersJSON['enrollment-type'] = [$(this).val()];
    filterArray[1] = [$(this).val()];
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$('#gnsm-target-population').on('change', function () {

    parametersJSON['target-population'] = [$(this).val()];
    filterArray[2] = [$(this).val()];
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$("#gnsm-grades-served").change(function () {

    parametersJSON['grades-served'] = $(this).val();
    filterArray[3] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$("#gnsm-services").change(function () {

    parametersJSON['services'] = $(this).val();
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
        .on("mouseover", function (d) {
            tooltip.transition()
                .duration(500)
                .style("opacity", 0);
            tooltip.transition()
                .duration(200)
                .style("opacity", 1);
            tooltip.html('<b>' + d.properties.boroname + '</b>')
                .style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY - 28) + "px");
        })
        .on("mouseleave", function (d) {
            tooltip.transition()
                .duration(200)
                .style("opacity", 0);
        })
        .on("click", clicked)
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
        .style("pointer-events", 'none')
})


function clicked(d) {
    var curBoro = d.properties.boroname.replace(" Island", "");
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

    tooltip.transition()
        .duration(200)
        .style("opacity", 0);

    borG.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")")

    ntaG.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")")

    ntaG.selectAll(".neighborhood")
        .style("pointer-events", function (d) {
            if (d.properties.boroname === curBoro) {
                return 'all'
            } else {
                return 'none'
            }
        })
        .on("mouseenter", function (d) {
            if (d.density != undefined) {
                tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
                tooltip.transition()
                    .duration(200)
                    .style("opacity", 1);
                tooltip.html('<b>' + d.properties.ntaname + ': </b>' + d.density)
                    .style("left", (d3.event.pageX) + "px")
                    .style("top", (d3.event.pageY - 28) + "px");
            }
        })
        .on("mouseleave", function (d) {
            tooltip.transition()
                .duration(200)
                .style("opacity", 0);
        })
        .on("click", function () {
            if (d.density != undefined) {
                tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
                tooltip.transition()
                    .duration(200)
                    .style("opacity", .9);
                tooltip.html('<b>' + d.properties.ntaname + ': </b>' + d.density)
                    .style("left", (d3.event.pageX) + "px")
                    .style("top", (d3.event.pageY - 28) + "px");
            }
        })


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

    ntaG.selectAll(".neighborhood")
        .style("pointer-events", 'none')
}


GETURIRequest.decode = function () {
    // retrieves GET request from URI and returns parameters as JSON
    // returns false if no parameters assigned
    var URIsearch = location.search,
        requestParameters = {},
        requests = [],
        i = 0,
        keyValPair = [];

    if (URIsearch.length > 1) {
        URIsearch = URIsearch.substr(1);
        URIsearch = URIsearch.split('&');

        for (i = 0; i < URIsearch.length; i++) {
            keyValPair = [];
            keyValPair = URIsearch[i].split('=');
            keyValPair[0] = decodeURIComponent(keyValPair[0]);
            keyValPair[1] = decodeURIComponent(keyValPair[1].replace(/\+/g, ' '));

            if (typeof requestParameters[keyValPair[0]] == 'undefined') {
                requestParameters[keyValPair[0]] = [];
            }

            requestParameters[keyValPair[0]].push(decodeURI(keyValPair[1]));
        }

        return requestParameters;
    } else {
        return false;
    }
};

GETURIRequest.encode = function (parametersJSON, baseURL) {
    // accepts object in the same format as the output of GETURIRequest.decode
    // returns string that can be appended to URI
    var URIsearch = '',
        key = '',
        i = 0,
        isFirst = true;

    for (var keyArray in parametersJSON) {
        if (parametersJSON.hasOwnProperty(keyArray)) {
            key = encodeURIComponent(keyArray);

            for (i = 0; i < parametersJSON[keyArray].length; i++) {
                if (isFirst) {
                    URIsearch += '?';
                    isFirst = false;
                } else {
                    URIsearch += '&';
                }
                URIsearch += key.replace(/ /g, '+');
                URIsearch += '=';
                URIsearch += encodeURIComponent(parametersJSON[keyArray][i]).replace(/ /g, '+');
            }
        }
    }

    return baseURL + URIsearch;
};

$(document).ready(function () {
    $('.link-to-listings').click(function () {
        console.log(GETURIRequest.encode(parametersJSON, 'http://54.174.151.164/GraduateNYC/gnsm_listing/'))
        window.location.href = GETURIRequest.encode(parametersJSON, 'http://54.174.151.164/GraduateNYC/gnsm_listing/')
    })
});