"use strict";

var GETURIRequest = {};
var GNYC = {
    'url': {
        "base": window.location.origin,
        "rootPath": window.location.pathname.substring(0, window.location.pathname.indexOf("/", 1)),
        "basePath": function() {
            return this.base + this.rootPath + '/';
        },
        "parameters": {},
    },
    'filters': {
        'boroughs': {
            'order': 0,
            'dataSetName': 'boroughs',
            'type': 'checkbox',
            'onMap': false,
            'onListings': true,
            'values': [
                'Brooklyn',
                'Bronx',
                'Manhattan',
                'Queens',
                'Staten Island',
            ],
            'defaultValue': [],
            'selected': [],
            'density': {
                'Brooklyn': {},
                'Queens': {},
                'Bronx': {},
                'Staten Island': {},
                'Manhattan': {},
            },
        },
        'population-served': {
            'order': 2,
            'dataSetName': 'target_population',
            'type': 'radio',
            'onMap': true,
            'onListings': true,
            'values': [
                'All',
                'Academic performance level',
                'English language learners',
                'Disconnected youth/Out of school youth',
                'Student with IEP or other learning challenges',
                'High school equivalency (HSE)',
                'Poverty guidelines/socioeconomic status',
                'Justice involved youth',
                'Gender',
                'Immigrants/Refugees',
            ],
            'defaultValue': 'All',
            'selected': 'All', 
            'oldName': 'target-population',
        },
        'grades-served': {
            'order': 3,
            'dataSetName': 'grades',
            'type': 'checkbox',
            'onMap': true,
            'onListings': true,
            'values': [
                'Elementary school (K-5)',
                'Middle school (6-8)',
                'High school (9-12)',
                'Post-secondary school',
                'Adult learners and High School Equivalency',
            ],
            'defaultValue': [],
            'selected': [],
        },
        'enrollment-type': {
            'order': 1,
            'dataSetName': 'accepting_students',
            'type': 'radio',
            'onMap': true,
            'onListings': true,
            'values': [
                'All',
                'Open enrollment',
                'Limited enrollment',
                'Closed program',
            ],
            'defaultValue': 'All',
            'selected': 'All', 
            'oldName': 'open-status',
        },
        'services': {
            'order': 4,
            'dataSetName': 'services',
            'type': 'checkbox',
            'onMap': true,
            'onListings': true,
            'values': [
                'College Readiness',
                'College Matriculation',
                'College Retention',
                'Career Preparation',
            ],
            'defaultValue': [],
            'selected': [],
        },
    },
    'venues': [
        'map',
        'listings',
    ],
    'map': {
        "width": 600,
        "height": 600,
        "active": d3.select(null),
    },
    'data': {
        "all": {},
    },
};


GNYC.map.tooltip = d3.select("body")
    .append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

d3.select(".map")
    .append("div")
    .classed("svg-container", true);

GNYC.svg = d3.select(".svg-container").append("svg")
    .attr("preserveAspectRatio", "xMinYMin meet")
    .attr("viewBox", "0 0 " + GNYC.map.width + " " + GNYC.map.height)
    .classed("svg-content-responsive", true);

GNYC.projection = d3.geo.mercator()
    .center([-73.94, 40.70])
    .scale(50000)
    .translate([(GNYC.map.width) / 2, (GNYC.map.height) / 2]);

GNYC.path = d3.geo.path()
    .projection(GNYC.projection)

GNYC.svg.append("rect")
    .attr("class", "background")
    .attr("width", GNYC.map.width)
    .attr("height", GNYC.map.height)
    .on("click", function() {
        GNYC.reset();
    });

GNYC.groups = {
    "neighborhoods": GNYC.svg.append("g"),
    "boroughs": GNYC.svg.append("g"),
};


// Combine prefix and filter name to create field ID
GNYC.filterToFieldID = function(filter, prefix) {
    return prefix + '-' + filter;
};


// Range of colors based on density
GNYC.color = d3.scale.linear()
    .domain([0, 60])
    .range(["white", "#2F5C61"]);


// Create filter form fields
GNYC.createFilterFormFields = function(venue) {
    var fieldSet = {},
        fieldInput = '',
        i = 0;

    if ($.inArray(venue, this.venues) > -1) {
        for (var filter in this.filters) {
            if (GNYC.filters[filter]['on' + venue.substring(0, 1).toUpperCase() + venue.substring(1)]) {
                fieldSet = $('#' + this.filterToFieldID(filter, 'panel') + ' fieldset');

                for (i = 0; i < this.filters[filter].values.length; i++) {
                    fieldInput += '<div class="' + this.filters[filter].type + '">';
                    fieldInput += '<span class="field-input">';
                    fieldInput += '<input type="' + this.filters[filter].type + '" ';
                    if (this.filters[filter].type === 'checkbox') {
                        fieldInput += 'class="styled" ';
                    }
                    fieldInput += 'name="' + this.filterToFieldID(filter, 'gnsm') + '" ';
                    fieldInput += 'id="' + this.filterToFieldID(filter, 'gnsm') + i + '" ';
                    fieldInput += 'value="' + this.filters[filter].values[i] + '" />';
                    fieldInput += '<label for="' + this.filterToFieldID(filter, 'gnsm') + i + '">';
                    fieldInput += this.filters[filter].values[i] + '</label>' + '</span>';
                    fieldInput += '</div>';

                    fieldSet.append(fieldInput);
                    fieldInput = '';
                } 
            }
        }
    } else {
        console.warn('ERROR: invalid venue');
    }
};


GNYC.noQuerySetUp = function() {
    for (var filter in GNYC.filters) {
        if (GNYC.filters.hasOwnProperty(filter)) {
            if (GNYC.filters[filter].type === 'checkbox') {
                GNYC.url.parameters[filter] = GNYC.filters[filter].defaultValue;
                GNYC.filters[filter].selected = GNYC.filters[filter].defaultValue;
            } else if (GNYC.filters[filter].type === 'radio') {
                GNYC.url.parameters[filter] = [GNYC.filters[filter].defaultValue];
                GNYC.filters[filter].selected = GNYC.filters[filter].defaultValue;
            } else {
                console.warn('ERROR: INVALID FILTER TYPE: in noQuerySetUp()');
            }
        }
    }

    GNYC.updateFilterFieldSelections()
};


GNYC.updateFilterFieldSelections = function () {
    for (var filter in GNYC.filters) {
        var thisInput = $('input[name="' + GNYC.filterToFieldID(filter, 'gnsm') + '"]');

        thisInput.each(function() {
            if (GNYC.filters[filter].type === 'checkbox') {
                if (GNYC.filters[filter].selected.indexOf($(this).val()) > -1) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }
            } else if (GNYC.filters[filter].type === 'radio') {
                if (GNYC.filters[filter].selected === $(this).val()) {
                    this.checked = true;
                } else {
                    this.checked = false;
                }
            } else {
                console.warn('ERROR: invalid field type');
            }
        });
    }
};

d3.json(GNYC.url.basePath() + '?crc-json=all_listings', function (error, json) {
    if (error) {
        return console.warn(error);
    }

    GNYC.data.all = json;
//    GNYC.setBoroughDensity(GNYC.createFilteredObj(GNYC.data.all));
    GNYC.setBoroughDensity(GNYC.getFilteredData(GNYC.data.all));
});

GNYC.setBoroughDensity = function (data) {
    for (borough in GNYC.filters.boroughs.density) {
        GNYC.filters.boroughs.density[borough] = {};
    }

    for (var borough in GNYC.filters.boroughs.density) {
        for (var program in data) {
            if (data[program].boroughs.indexOf(borough) >= -1) {
                for (var i = 0; i < data[program].neighborhoods.length; i++) {
                    if (data[program].neighborhoods[i].indexOf(borough) > -1) {
                        if (data[program].neighborhoods[i] in GNYC.filters.boroughs.density[borough]) {
                            GNYC.filters.boroughs.density[borough][data[program].neighborhoods[i]] += 1;
                        } else {
                            GNYC.filters.boroughs.density[borough][data[program].neighborhoods[i]] = 1;
                        }
                    }
                }
            }
        }
    }

    GNYC.updateMap();
}

GNYC.getFilteredData = function (programsAll) {
    var filteredData = {};

    var includeProgram = function (programToCheck) {
        var isExcluded = {
            'radio': function (thisProgram, thisSelected, thisFilter) {
                // if selected equal to default, don't exclude program
                if (thisSelected === GNYC.filters[thisFilter].defaultValue) {
                    return false;
                // if selected in program, don't exclude program
                //
                } else if (thisProgram[GNYC.filters[thisFilter].dataSetName].indexOf(thisSelected) > -1) {
                    return false;
                // otherwise, exclude program
                } else {
                    return true;
                }
            },
            'checkbox': function (thisProgram, thisSelected, thisFilter) {
                // if nothing is selected, do not exclude based upon this filter
                if (thisSelected.length === 0) {
                    return false;
                } else {
                    var i = 0;
                    // for each selected
                    for (i = 0; i < thisSelected.length; i++) {
                        // if selected item not in program attributes, return true
                        if (thisProgram[GNYC.filters[filter].dataSetName].indexOf(thisSelected[i]) === -1) {
                            return true;
                        }
                    }
                }

                return false;
            },
        };

        for (var filter in GNYC.filters) {
            if (GNYC.filters.hasOwnProperty(filter)) {
                // rename program, selected, and filter
                if (isExcluded[GNYC.filters[filter].type](programToCheck,
                                                          GNYC.filters[filter].selected,
                                                          filter)) {
                    return false;
                }
            }
        }

        return true; // return true if isExcluded didn't return false
    };

    for (var program in programsAll) {
        if (includeProgram(programsAll[program])) {
            filteredData[program] = programsAll[program];
        }
    }

    return filteredData;
};

GNYC.getDensityColor = function(d) {
    for (var neighborhoodBorough in GNYC.filters.boroughs.density[d.properties.boroname]) {
        var neighborhood = neighborhoodBorough.split(' - ')[1];

        if (d.properties.ntaname.indexOf(neighborhood) > -1) {
            d.density = GNYC.filters.boroughs.density[d.properties.boroname][neighborhoodBorough];

            return GNYC.color(GNYC.filters.boroughs.density[d.properties.boroname][neighborhoodBorough]);
        }
    }

    return GNYC.color(0);
};

GNYC.updateMap = function () {
    d3.selectAll('.neighborhood').transition()
        .duration(750)
        .style('fill', function(d) {
            return GNYC.getDensityColor(d);
        });
};


// Update breadcrumbs
GNYC.updateBreadcrumbs = function(thisFilter) {
    var theseBreadcrumbs = $('#' + this.filterToFieldID(thisFilter, 'panel') + ' p.breadcrumbs');

    if (this.filters[thisFilter].type === 'radio') {
        theseBreadcrumbs.html(this.filters[thisFilter].selected);
    } else if (this.filters[thisFilter].type === 'checkbox') {
        theseBreadcrumbs.html('');

        for (var i = 0; i < this.filters[thisFilter].selected.length; i++) {
            if (i !== 0) {
                theseBreadcrumbs.append('; ');
            }
            theseBreadcrumbs.append(this.filters[thisFilter].selected[i]) ;
        }
    } else {
        console.warn('ERROR: invalid field type');
    }
};


// Add on change action to each form filter
GNYC.createFormEventListeners = function() {
    for (var filter in GNYC.filters) {
        var i = 0;

        for (i = 0; i < GNYC.filters[filter].values.length; i++) {
            $('#' + GNYC.filterToFieldID(filter, 'gnsm') + i).on('change', function() {
                var thisFilter = this.name.substring(5);
                GNYC.filters[thisFilter].selected = GNYC.filters[thisFilter].defaultValue.slice();

                $('input[name="' + GNYC.filterToFieldID(thisFilter, 'gnsm') + '"]:checked').each(function() {
                    if (GNYC.filters[thisFilter].type === 'checkbox') {
                        GNYC.filters[thisFilter].selected.push($(this).val());
                    } else if (GNYC.filters[thisFilter].type === 'radio') {
                        GNYC.filters[thisFilter].selected = $(this).val();
                    } else {
                        console.warn('ERROR: invalid field type');
                    }
                });

                GNYC.url.parameters[thisFilter] = GNYC.filters[thisFilter].selected.slice();
                GNYC.filters[thisFilter].selected = GNYC.filters[thisFilter].selected.slice();
//                GNYC.setBoroughDensity(GNYC.createFilteredObj(GNYC.data.all));
                GNYC.setBoroughDensity(GNYC.getFilteredData(GNYC.data.all));
                GNYC.updateBreadcrumbs(thisFilter);
            });
        }
    }
};

d3.json("../wp-content/plugins/crc-graduate-nyc-survey-map/includes/static/Boroughs.json", function (error, borough) {
    GNYC.groups.boroughs.selectAll(".borough")
        .data(topojson.feature(borough, borough.objects.Boroughs).features)
        .enter().append("path")
        .attr("class", "borough")
        .attr("id", function (d) {
            return d.properties.boroname;
        })
        .attr("d", GNYC.path)
        .on("mouseover", function (d) {
            GNYC.map.tooltip.transition()
                .duration(500)
                .style("opacity", 0);
            GNYC.map.tooltip.transition()
                .duration(200)
                .style("opacity", 1);
            GNYC.map.tooltip.html('<b>' + d.properties.boroname + '</b>')
                .style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY - 28) + "px");
        })
        .on("mouseleave", function (d) {
            GNYC.map.tooltip.transition()
                .duration(200)
                .style("opacity", 0);
        })
        .on("click", GNYC.clicked)
})

d3.json("../wp-content/plugins/crc-graduate-nyc-survey-map/includes/static/NTA.json", function (error, nta) {
    GNYC.groups.neighborhoods.selectAll(".neighborhood")
        .data(topojson.feature(nta, nta.objects.NTA).features)
        .enter().append("path")
        .attr("class", "neighborhood")
        .attr("id", function (d) {
            return d.properties.ntaname;
        })
        .attr("d", GNYC.path)
        .style('fill', function(d) {
            return GNYC.getDensityColor(d);
        })
        .style('stroke-width', '.5px')
        .style("stroke", "#cecece")
        .style("pointer-events", 'none');
});


GNYC.clicked = function(d) {
    var curBoro = d.properties.boroname;

    if (GNYC.map.active.node() === this) return GNYC.reset();
    GNYC.map.active.classed("active", false);
    GNYC.map.active = d3.select(this).classed("active", true);

    var bounds = GNYC.path.bounds(d),
        dx = bounds[1][0] - bounds[0][0],
        dy = bounds[1][1] - bounds[0][1],
        x = (bounds[0][0] + bounds[1][0]) / 2,
        y = (bounds[0][1] + bounds[1][1]) / 2,
        scale = .5 / Math.max(dx / GNYC.map.width, dy / GNYC.map.height),
        translate = [GNYC.map.width / 2 - scale * x, (GNYC.map.height / 2 - scale * y) - 10];

    if (curBoro === 'Queens') {
        scale += .5;
        translate = [translate[0] * 2.5, translate[1] * 3.25];
    }

    d3.select(".background")
        .attr("cursor", "zoom-out")

    GNYC.map.tooltip.transition()
        .duration(200)
        .style("opacity", 0);

    GNYC.groups.boroughs.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")")

    GNYC.groups.neighborhoods.transition()
        .duration(750)
        .style("stroke-width", 1.5 / scale + "px")
        .attr("transform", "translate(" + translate + ")scale(" + scale + ")")

    GNYC.groups.neighborhoods.selectAll(".neighborhood")
        .style("pointer-events", function (d) {
            if (d.properties.boroname === curBoro) {
                return 'all';
            } else {
                return 'none';
            }
        })
        .on("mouseenter", function (d) {
            if (d.density != undefined) {
                GNYC.map.tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
                GNYC.map.tooltip.transition()
                    .duration(200)
                    .style("opacity", 1);
                GNYC.map.tooltip.html('<strong>' + d.properties.ntaname + ': </strong>' + d.density)
                    .style("left", (d3.event.pageX) + "px")
                    .style("top", (d3.event.pageY - 28) + "px");
            }
        })
        .on("mouseleave", function (d) {
            GNYC.map.tooltip.transition()
                .duration(200)
                .style("opacity", 0);
        })
        .on("click", function () {
            if (d.density != undefined) {
                GNYC.map.tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
                GNYC.map.tooltip.transition()
                    .duration(200)
                    .style("opacity", .9);
                GNYC.map.tooltip.html('<strong>' + d.properties.ntaname + ': </strong>' + d.density)
                    .style("left", (d3.event.pageX) + "px")
                    .style("top", (d3.event.pageY - 28) + "px");
            }
        })
}

GNYC.reset = function() {
    GNYC.map.active.classed("active", false);
    GNYC.map.active = d3.select(null);

    d3.select(".background")
        .attr("cursor", "default")

    GNYC.groups.boroughs.transition()
        .duration(750)
        .style("stroke-width", "1.5px")
        .attr("transform", "");
    GNYC.groups.neighborhoods.transition()
        .duration(750)
        .attr("transform", "");

    GNYC.groups.neighborhoods.selectAll(".neighborhood")
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

GETURIRequest.encode = function (parameters, baseURL) {
    // accepts object in the same format as the output of GETURIRequest.decode
    // returns string that can be appended to URI
    var URIsearch = '',
        key = '',
        i = 0,
        isFirst = true;

    for (var keyArray in parameters) {
        if (parameters.hasOwnProperty(keyArray)) {
//        if (parameters.hasOwnProperty(keyArray) && parameters[keyArray] !== null) {
//            console.log(parameters);
            key = encodeURIComponent(keyArray);

            for (i = 0; i < parameters[keyArray].length; i++) {
                if (isFirst) {
                    URIsearch += '?';
                    isFirst = false;
                } else {
                    URIsearch += '&';
                }
                URIsearch += key.replace(/ /g, '+');
                if (parameters[keyArray].length > 1) {
                        URIsearch += '%5B%5D';
                }
                URIsearch += '=';
                URIsearch += encodeURIComponent(parameters[keyArray][i]).replace(/ /g, '+');
            }
        }
    }

    return baseURL + URIsearch;
};


GNYC.processURI = function() {
    if (GETURIRequest.decode()) {
        GNYC.url.parameters = GETURIRequest.decode();

        for (var filter in GNYC.filters) {
            if (GNYC.filters[filter].type === 'checkbox') {
                GNYC.filters[filter].selected = GNYC.url.parameters[filter];
            } else if (GNYC.filters[filter].type === 'radio') {
                GNYC.filters[filter].selected = GNYC.url.parameters[filter][0];
            } else {
                console.warn('ERROR: invalid filter type');
            }
        }

        GNYC.updateFilterFieldSelections();
    } else {
        GNYC.noQuerySetUp();
    }
}


$(document).ready(function () {
    // Set global GNYC.venue from GNYC_VENUE global and delete GNYC_VENUE global
    if (window.hasOwnProperty('GNYC_VENUE')) {
        GNYC.venue = GNYC_VENUE;
    }

    // If venue not in GNYC.venues:
    if ($.inArray(GNYC.venue, GNYC.venues) > -1) {
    // Get URI parameters if passed
        GNYC.processURI();

        GNYC.createFilterFormFields(GNYC.venue);
        // Load data
        // Update filters
        // Update results (map/listings and link-to-other-venue)
        // Update listings (and link-to-map)
        $('.link-to-listings').click(function () {
            window.location.href = GETURIRequest.encode(GNYC.url.parameters, GNYC.url.basePath() + 'gnsm_listing/');
        });

        // Create form event listeners
        GNYC.createFormEventListeners();
    } else {
      // DO NOTHING
    }
});


