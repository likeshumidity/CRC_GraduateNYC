"use strict";

var GNYC = {};

// [formElementID, index, selectionType, shortName, onMapFilters, defaultSelection]
GNYC.filters = [
    ['gnsm-boroughs', 0, 'multiple', 'boroughs', false, []],
    ['gnsm-open-status', 1, 'single', 'open-status', true, 'All'],
    ['gnsm-target-population', 2, 'single', 'target-population', true, 'All'],
    ['gnsm-grades-served', 3, 'multiple', 'grades-served', true, []],
    ['gnsm-services', 4, 'multiple', 'services', true, []],
    ];

GNYC.boroughs = {
    'density': {
        'Brooklyn': {},
        'Queens': {},
        'Bronx': {},
        'Staten Island': {},
        'Manhattan': {},
    },
    };

var GETURIRequest = {};

var width = 700,
    height = 1165,
    active = d3.select(null);

var tooltip = d3.select("body")
    .append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

d3.select(".map")
    .append("div")
    .classed("svg-container", true);

var boroughSvg = d3.select(".svg-container").append("svg")
    .attr("preserveAspectRatio", "xMinYMin meet")
    .attr("viewBox", "0 0 " + width + " " + height)
    .classed("svg-content-responsive", true);

var neighborhoodSvg = d3.select(".svg-container").append("svg")
    .style("pointer-events", 'none')
    .attr("preserveAspectRatio", "xMinYMin meet")
    .attr("viewBox", "0 0 " + width + " " + height)
    .classed("svg-content-responsive", true);

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
//    curTarget = "All",
    parametersJSON = {},
    filterArray = [];


var allData = {};
var curData = {};


var noQuerySetUp = function () {
/*
    for (var i = 0; i < GNYC.filters.length; i++) {
        if (GNYC.filters[i][2] == 'multiple') {
            parametersJSON[GNYC.filters[i][3]] = GNYC.filters[i][5];
        } else {
            parametersJSON[GNYC.filters[i][3]] = [GNYC.filters[i][5]];
        }
    }
*/
    filterArray = [
        [],
        "All",
        "All",
        [],
        [],
    ];

    parametersJSON['boroughs'] = filterArray[0];
    parametersJSON['enrollment-type'] = [filterArray[1]];
    parametersJSON['target-population'] = [filterArray[2]];
    parametersJSON['grades-served'] = filterArray[3];
    parametersJSON['services'] = filterArray[4];

    setUpSelections();
}

var setUpSelections = function () {
/*
    for (var i = 0; i < GNYC.filters.length; i++) {
        var selectedForm = document.getElementById(GNYC.filters[i][0]);

        for (var j = 0; j < selectedForm.options.length; j++) {
            if (GNYC.filters[i][2] === 'multiple') {
                if (filterArray[GNYC.filters[i][1]].indexOf(selectedForm.options[j].value) > -1) {
                    selectedForm.options[j].selected = true;
                } else {
                    selectedForm.options[j].selected = false;
                }
            } else {
                if (filterArray[GNYC.filters[i][1]] === selectedForm.options[j].value) {
                    selectedForm.options[j].selected = true;
                } else {
                    selectedForm.options[j].selected = false;
                }
            }
        }
    }
//*/
    for (var i = 0; i < GNYC.filters.length; i++) {
        var thisInput = $('input[name="' + GNYC.filters[i][0] + '"]');

        thisInput.each(function () {
            if (GNYC.filters[i][2] === 'multiple') {
                if (filterArray[GNYC.filters[i][1]].indexOf($(this).val()) > -1) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }
            } else {
                if (filterArray[GNYC.filters[i][1]] === $(this).val()) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }
            }
        });
    }
//*/
}

d3.json("http://54.174.151.164/GraduateNYC/?crc-json=all_listings", function (error, json) {
    if (error) {
        return console.warn(error);
    }

    allData = json;
    var filterData = createFilteredObj(allData);
    setUpArrays(filterData);
});

var setUpArrays = function (data) {
    BrooklynArray = {};
    BronxArray = {};
    QueensArray = {};
    ManhattanArray = {};
    StatenArray = {};

//*
    for (var bor in GNYC.boroughs.density) {
//        bor = bor.replace(" Island", "");

        for (var key in data) {
            if (data[key].boroughs.indexOf(bor) >= -1) {
                for (var i = 0; i < data[key].neighborhoods.length; i++) {
                    if (data[key].neighborhoods[i].indexOf(bor) > -1) {
//console.log(data[key].neighborhoods[i]);
//console.log(GNYC.boroughs.density[bor]);
                        if (data[key].neighborhoods[i] in GNYC.boroughs.density[bor]) {
                            GNYC.boroughs.density[bor][data[key].neighborhoods[i]] += 1;
//                            console.log(bor + ' - +=1');
                        } else {
                            GNYC.boroughs.density[bor][data[key].neighborhoods[i]] = 1;
//                            console.log(bor + ' - =1');
                        }
                    }
                }
            }
        }
    }
//*/

    for (var key in data) {
//console.log(key);
        if (data[key].boroughs.indexOf("Brooklyn") >= -1) {
            for (var i = 0; i < data[key].neighborhoods.length; i++) {
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
            for (var j = 0; j < data[key].neighborhoods.length; j++) {
                if (data[key].neighborhoods[j].indexOf("Queens") > -1) {
                    if (data[key].neighborhoods[j] in QueensArray) {
                        QueensArray[data[key].neighborhoods[j]] += 1;
                    } else {
                        QueensArray[data[key].neighborhoods[j]] = 1;
                    }
                }
            }
        }

        if (data[key].boroughs.indexOf("Bronx") >= -1) {
            for (var k = 0; k < data[key].neighborhoods.length; k++) {
                if (data[key].neighborhoods[k].indexOf("Bronx") > -1) {
                    if (data[key].neighborhoods[k] in BronxArray) {
                        BronxArray[data[key].neighborhoods[k]] += 1;
                    } else {
                        BronxArray[data[key].neighborhoods[k]] = 1;
                    }
                }
            }
        }

        if (data[key].boroughs.indexOf("Staten") >= -1) {
            for (var l = 0; l < data[key].neighborhoods.length; l++) {
                if (data[key].neighborhoods[l].indexOf("Staten") > -1) {
                    if (data[key].neighborhoods[l] in StatenArray) {
                        StatenArray[data[key].neighborhoods[l]] += 1;
                    } else {
                        StatenArray[data[key].neighborhoods[l]] = 1;
                    }
                }
            }
        }

        if (data[key].boroughs.indexOf("Manhattan") >= -1) {
            for (var m = 0; m < data[key].neighborhoods.length; m++) {
                if (data[key].neighborhoods[m].indexOf("Manhattan") > -1) {
                    if (data[key].neighborhoods[m] in ManhattanArray) {
                        ManhattanArray[data[key].neighborhoods[m]] += 1;
                    } else {
                        ManhattanArray[data[key].neighborhoods[m]] = 1;
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
    var neighbCheck = true;
    for (var i = 0; i < filterArray[0].length; i++) {
        if (program.boroughs.indexOf(filterArray[0][i]) > -1) {
            neighbCheck = true;
        } else {
            neighbCheck = false;
            break;
        }
    }
    if (neighbCheck === false && filterArray[0].length !== 0) {
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
    var gradesCheck = true;
    for (var j = 0; j < filterArray[3].length; j++) {
        if (program.grades.indexOf(filterArray[3][j]) > -1) {
            gradesCheck = true;
        } else {
            gradesCheck = false;
            break;
        }
    }
    if (gradesCheck === false && filterArray[3].length !== 0) {
        return false;
    }

    //check services
    var serviceCheck = true;
    for (var k = 0; k < filterArray[4].length; k++) {
        if (program.services.indexOf(filterArray[4][k]) > -1) {
            serviceCheck = true;
        } else {
            serviceCheck = false;
            break;
        }
    }
    if (serviceCheck === false && filterArray[4].length !== 0) {
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
    return filterObj;
}

var updateMap = function () {
//*
    var breadcrumbs = "",
        i = 0,
        j = 0;

    var filters = [
        'gnsm-boroughs',
        'gnsm-open-status',
        'gnsm-population',
        'gnsm-grades-served',
        'gnsm-services',
        ];

    for (i = 0; i < breadcrumbs.length; i++) {
        var snippet = filters[0].substring(4).replace('-',' '),
            capitalizeNext = false;

        for (j = 0; j < snippet.length; j++) {
            if (j === 0) {
                snippet[j] = snippet[j].toUpperCase;
            }

            if (snippet[j] === ' ') {
                capitalizeNext = true;
            } else {
                capitalizeNext = false;
            }
        }

        breadcrumbs += snippet;
    }

    $('.breadcrumbs p').html(breadcrumbs);
//*/

    d3.selectAll('.neighborhood').transition()
        .duration(750)
        .style("fill", function (d) {
//*/
//            for (var key in GNYC.boroughs.density
//*/
            for (var key in window[d.properties.boroname + "Array"]) {
console.log(key);
console.log(window[d.properties.boroname + 'Array']);
                var neighb = key.split(" - ")[1]
                if (d.properties.ntaname.indexOf(neighb) > -1) {
                    d.density = window[d.properties.boroname + "Array"][key];
                    return color(window[d.properties.boroname + "Array"][key])
                }
            }
//*
            return color(0)
        });
}


/*
GNYC.filters = [
    ['gnsm-boroughs', 0, 'multiple', 'boroughs', false, []],
    ['gnsm-open-status', 1, 'single', 'open-status', true, 'All'],
    ['gnsm-target-population', 2, 'single', 'target-population', true, 'All'],
    ['gnsm-grades-served', 3, 'multiple', 'grades-served', true, []],
    ['gnsm-services', 4, 'multiple', 'services', true, []],
    ];

*/

$('#gnsm-boroughs').on('change', function () {
    var array = $(this).val()? $(this).val(): [];
    parametersJSON['boroughs'] = array;
    filterArray[0] = array;
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$('#gnsm-open-status').on('change', function () {
    parametersJSON['enrollment-type'] = [$(this).val()];
    filterArray[1] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$('#gnsm-target-population').on('change', function () {
    parametersJSON['target-population'] = [$(this).val()];
    filterArray[2] = $(this).val();
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$("#gnsm-grades-served").change(function () {
    var array = $(this).val()? $(this).val(): [];
    parametersJSON['grades-served'] = array;
    filterArray[3] = array;
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});

$("#gnsm-services").change(function () {
    var array = $(this).val()? $(this).val(): [];
    parametersJSON['services'] = array;
    filterArray[4] = array;
    var filterData = createFilteredObj(allData)
    setUpArrays(filterData)
});


d3.json("../wp-content/plugins/crc-graduate-nyc-survey-map/includes/static/Boroughs.json", function (error, bor) {

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

d3.json("../wp-content/plugins/crc-graduate-nyc-survey-map/includes/static/NTA.json", function (error, nta) {

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
        translate = [width / 2 - scale * x, (height / 2 - scale * y) - 130];

    d3.select(".background")
        .attr("cursor", "zoom-out")

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
                return 'all';
            } else {
                return 'none';
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

    d3.select(".background")
        .attr("cursor", "default")

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
//        if (parametersJSON.hasOwnProperty(keyArray) && parametersJSON[keyArray] !== null) {
//            console.log(parametersJSON);
            key = encodeURIComponent(keyArray);

            for (i = 0; i < parametersJSON[keyArray].length; i++) {
                if (isFirst) {
                    URIsearch += '?';
                    isFirst = false;
                } else {
                    URIsearch += '&';
                }
                URIsearch += key.replace(/ /g, '+');
                if (parametersJSON[keyArray].length > 1) {
                        URIsearch += '%5B%5D';
//                      console.log(keyArray);
//                      console.log(parametersJSON[keyArray].length);
                }
                URIsearch += '=';
                URIsearch += encodeURIComponent(parametersJSON[keyArray][i]).replace(/ /g, '+');
            }
        }
    }

    return baseURL + URIsearch;
};


$(document).ready(function () {

    if (GETURIRequest.decode()) {
        parametersJSON = GETURIRequest.decode();

        filterArray[0] = parametersJSON['boroughs'];
        filterArray[1] = parametersJSON['enrollment-type'][0];
        filterArray[2] = parametersJSON['target-population'][0];
        filterArray[3] = parametersJSON['grades-served'];
        filterArray[4] = parametersJSON['services'];

        setUpSelections();

    } else {
        noQuerySetUp();
    }
    $('.link-to-listings').click(function () {
        window.location.href = GETURIRequest.encode(parametersJSON, 'http://54.174.151.164/GraduateNYC/gnsm_listing/');
    })
});
