"use strict";

var GETURIRequest = {
    'decode': function () {
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
    },
};


var GNYC = {
    'url': {
        "base": window.location.origin,
        "rootPath": window.location.pathname.substring(0, window.location.pathname.indexOf("/", 1)),
        "basePath": function() {
            return this.base + this.rootPath + '/';
        },
    },
    'addressParts': [
        ['address_line_1', 0],
        ['address_line_2', 1],
        ['address_city', 1],
        ['address_state', 1],
        ['address_postal_code', 2],
    ],
    'filters': {
        'boroughs': {
            'dataSetName': 'boroughs',
            'type': 'checkbox',
            'onmap': false,
            'onlistings': true,
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
        'neighborhoods': {
            'dataSetName': 'neighborhoods',
            'type': 'radio',
            'onmap': false,
            'onlistings': true,
            'values': [
                'Any',
                'Brooklyn - Bay Ridge',
                'Brooklyn - Bedford Stuyvesant',
                'Brooklyn - Bensonhurst',
                'Brooklyn - Borough Park',
                'Brooklyn - Brownsville',
                'Brooklyn - Bushwick',
                'Brooklyn - Canarsie',
                'Brooklyn - Coney Island',
                'Brooklyn - Crown Heights North',
                'Brooklyn - Crown Heights South',
                'Brooklyn - East Flatbush',
                'Brooklyn - East New York',
                'Brooklyn - Flatbush/Midwood',
                'Brooklyn - Fort Greene/Brooklyn Heights',
                'Brooklyn - Park Slope',
                'Brooklyn - Sheepshead Bay',
                'Brooklyn - Sunset Park',
                'Brooklyn - Williamsburg/Greenpoint',
                'Bronx - Bedford Park',
                'Bronx - Concourse/Highbridge',
                'Bronx - East Tremont',
                'Bronx - Hunts Point',
                'Bronx - Morrisania',
                'Bronx - Mott Haven',
                'Bronx - Pelham Parkway',
                'Bronx - Riverdale',
                'Bronx - Throgs Neck',
                'Bronx - Unionport/Soundview',
                'Bronx - University Heights',
                'Bronx - Williamsbridge',
                'Manhattan - Battery Park/Tribeca',
                'Manhattan - Central Harlem',
                'Manhattan - Chelsea/Clinton',
                'Manhattan - East Harlem',
                'Manhattan - Greenwich Village',
                'Manhattan - Lower East Side',
                'Manhattan - Manhattanville',
                'Manhattan - Midtown Business District',
                'Manhattan - Murray Hill/Stuyvesant',
                'Manhattan - Upper East Side',
                'Manhattan - Upper West Side',
                'Manhattan - Washington Heights',
                'Queens - Astoria',
                'Queens - Bayside',
                'Queens - Elmhurst/Corona',
                'Queens - Flushing',
                'Queens - Fresh Meadows/Briarwood',
                'Queens - Howard Beach',
                'Queens - Jackson Heights',
                'Queens - Jamaica/St. Albans',
                'Queens - Queens Village',
                'Queens - Rego Park/Forest Hills',
                'Queens - Ridgewood/Glendale',
                'Queens - Sunnyside/Woodside',
                'Queens - The Rockaways',
                'Queens - Woodhaven',
                'Staten Island - South Beach',
                'Staten Island - St. George',
                'Staten Island - Tottenville',
            ],
            'defaultValue': 'Any',
            'selected': 'Any', 
        },
        'population-served': {
            'dataSetName': 'target_population',
            'type': 'radio',
            'onmap': true,
            'onlistings': true,
            'values': [
                'Any',
                'Academic performance level-Low',
                'Academic performance level-Average',
                'Academic performance level-High',
                'English language learners',
                'Disconnected youth/Out of school youth',
                'Students with IEP or other learning challenges',
                'High school equivalency (HSE)',
                'Justice involved youth',
                'Immigrants/Refugees',
            ],
            'defaultValue': 'Any',
            'selected': 'Any', 
        },
        'grades-served': {
            'dataSetName': 'grades',
            'type': 'checkbox',
            'onmap': true,
            'onlistings': true,
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
            'dataSetName': 'accepting_students',
            'type': 'radio',
            'onmap': true,
            'onlistings': true,
            'values': [
                'Any',
                'Open Enrollment',
                'Limited Enrollment',
                'Closed Program',
            ],
            'defaultValue': 'Any',
            'selected': 'Any', 
        },
        'eligibility-criteria': {
            'dataSetName': 'eligibility_criteria',
            'type': 'radio',
            'onmap': true,
            'onlistings': true,
            'values': [
                'Any',
                'K-12 enrollment',
                'College enrollment',
                'Grade level',
                'Geographic residence',
                'Member of a targeted population',
            ],
            'defaultValue': 'Any', 
            'selected': 'Any',
        },
        'services': {
            'dataSetName': 'services',
            'type': 'checkbox',
            'onmap': true,
            'onlistings': true,
            'values': [
                'College Readiness',
                'College Matriculation',
                'College Retention',
                'Career Preparation',
            ],
            'defaultValue': [],
            'selected': [],
        },
        'organization-type': {
            'dataSetName': 'organization_type',
            'type': 'radio',
            'onmap': false,
            'onlistings': true,
            'values': [
                'Direct service',
                'Supports the college access and success sector',
            ],
            'defaultValue': 'Direct service', 
            'selected': 'Direct service',
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
    'data': {},
    // Combine prefix and filter name to create field ID
    'filterToFieldID': function(filter, prefix) {
        return prefix + '-' + filter;
    },
    'listingReadmore': {
        'speed': 75,
        'moreLink': '<i class="fa fa-plus readmoreless"></i> more',
        'lessLink': '<i class="fa fa-minus readmoreless"></i> less',
        'heightMargin': 85,
    },
};


if (GNYC_VENUE === 'map') {
// map setup
    // Build map structure
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
        "CBOLocations": GNYC.svg.append("g"),
    };

    // Range of colors based on density
    GNYC.color = d3.scale.linear()
        .domain([0, 35])
        .range(["white", "#2F5C61"]);


    // Get borough outlines
    GNYC.loadMapBoroughs = function() {
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
                    GNYC.map.tooltip.attr('id', 'map-borough' + d.properties.boroname.replace(' ', '-'));
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
        });
    };
    
    
    // Get neighborhood outlines
    GNYC.loadMapNeighborhoods = function() {
        d3.json("../wp-content/plugins/crc-graduate-nyc-survey-map/includes/static/NYC-Community_Districts1470742305.58.json", function (error, nta) {
            GNYC.groups.neighborhoods.selectAll(".neighborhood")
                .data(topojson.feature(nta, nta.objects['88472a1f6fd94fef97b8c06335db60f7nyccommunitydistricts']).features)
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
    };


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
    
    
    // add CBO Locations to map
    GNYC.addCBOLocations = function(data) {
        GNYC.CBOLocations = [];
    
        for (var program in data) {
            if (data[program].cbo_latitude[0].length > 0 && data[program].cbo_longitude[0].length > 0) {
                GNYC.CBOLocations.push({
                    'name': data[program].program_name,
                    'lat': data[program].cbo_latitude[0],
                    'lng': data[program].cbo_longitude[0],
                    'school_partnerships': data[program].school_partnerships[0],
                });
            }
        }

        GNYC.groups.CBOLocations.selectAll(".cbo-location")
            .data(GNYC.CBOLocations).enter()
            .append('circle')
            .attr('class', 'cbo-location')
            .attr('cx', function(d) { return GNYC.projection([d.lng, d.lat])[0]; })
            .attr('cy', function(d) { return GNYC.projection([d.lng, d.lat])[1]; })
            .attr('r', '3px')
            .attr('fill', '#c05f5f');

// console.log(GNYC.CBOLocations);
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


    // onClick action for boroughs in map
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
                    GNYC.map.tooltip.html('<a href="' + $('.link-to-listings a').attr('href') + '&neighborhoods=' + encodeURIComponent(d.properties.boroname + ' - ' + d.properties.ntaname) +'"><strong>' + d.properties.ntaname + ': </strong>' + d.density + ' programs</a>')
                        .style("left", (d3.event.pageX) + "px")
                        .style("top", (d3.event.pageY - 28) + "px");
// console.log(d.properties);
                }
            })
/*
            .on("mouseleave", function (d) {
                GNYC.map.tooltip.transition()
                    .duration(200)
                    .style("opacity", 0);
            })
*/
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
            });

        GNYC.groups.CBOLocations.transition()
            .duration(750)
            .attr("r", 1.5 / scale + "px")
            .attr("transform", "translate(" + translate + ")scale(" + scale + ")");

        GNYC.groups.CBOLocations.selectAll('.cbo-location')
            .on("mouseenter", function (d) {
                GNYC.map.tooltip.transition()
                    .duration(500)
                    .style("opacity", 0);
                GNYC.map.tooltip.transition()
                    .duration(200)
                    .style("opacity", 1);
                GNYC.map.tooltip.html(function() {
                        var tooltip = d.name;
                        if (d.school_partnerships.length > 0) {
                            tooltip += ' <em>partners with</em>: ' + d.school_partnerships;
                        }

                        return tooltip;
                    })
                    .style("left", (d3.event.pageX) + "px")
                    .style("top", (d3.event.pageY - 28) + "px");
            });
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
    
        GNYC.groups.CBOLocations.transition()
            .duration(750)
            .attr("transform", "");

        GNYC.groups.CBOLocations.selectAll(".cbo-location")
            .style("pointer-events", 'none')

        GNYC.groups.neighborhoods.selectAll(".neighborhood")
            .style("pointer-events", 'none')
    }


    GNYC.updateMap = function () {
        d3.selectAll('.neighborhood').transition()
            .duration(750)
            .style('fill', function(d) {
                return GNYC.getDensityColor(d);
            });
    };
} else if (GNYC_VENUE === 'listings') {
// listing setup
    // Load listings
    GNYC.loadListings = function() {
        GNYC.listings = d3.select('ul.gnsm-program-listings')
            .selectAll('li')
            .data(GNYC.objToSortedArray(GNYC.getFilteredData(GNYC.data)))
            .enter()
            .append('li')
            .attr('class', 'program-listing')
            .html(function(d) {
                return GNYC.listingItemHTML(d);
            });

            $('.post-count').text(GNYC.objToSortedArray(GNYC.getFilteredData(GNYC.data)).length + ' matching programs');
    }

    GNYC.updateListings = function() {
        $('ul.gnsm-program-listings').html('');

        GNYC.listings = d3.select('ul.gnsm-program-listings')
            .selectAll('li')
            .data(GNYC.objToSortedArray(GNYC.getFilteredData(GNYC.data)))
            .enter()
            .append('li')
            .attr('class', 'program-listing')
            .html(function(d) {
                return GNYC.listingItemHTML(d);
            });

/*
        GNYC.listings.each(function(d, i) {
                $(GNYC.listings[0][i]).readmore(GNYC.listingReadmore);
            });
*/

            $('.post-count').text(GNYC.objToSortedArray(GNYC.getFilteredData(GNYC.data)).length + ' matching programs');
    };

    GNYC.listingItemHTML = function(item) {
        var htmlSnippet = '';
        htmlSnippet += '<div class="title">' + item.program_name + '</div>';
        htmlSnippet += '<div class="phone">' + item.contact_phone + '</div>';
        htmlSnippet += '<div class="physical-address">';
        htmlSnippet += '<span class="google-map-link">';
        htmlSnippet += '<a href="' + GNYC.googleMapLink(item) + '">';
        htmlSnippet += '<img src="../wp-content/plugins/crc-graduate-nyc-survey-map/includes/static/google-maps-logo.png" alt="Google Maps Link" width="20" height="20" />';

        for (var i = 0; i < GNYC.addressParts.length; i++) {
            var addressPart = {
                "class": GNYC.addressParts[i][0].substring(8).replace(/_/, '-'),
                "prefix": (function(hasPrefix) {
                    if (hasPrefix === 1) {
                        return ', ';
                    } else if (hasPrefix === 2) {
                        return ' ';
                    } else {
                        return '';
                    }
                })(GNYC.addressParts[i][1]),
            };

            if (item[GNYC.addressParts[i][0]][0].trim().length > 0) {
                htmlSnippet += '<span class="' + addressPart['class'] + '">';
                htmlSnippet += addressPart.prefix;
                htmlSnippet += item[GNYC.addressParts[i][0]][0].trim();
                htmlSnippet += '</span>';
            }
        }

        htmlSnippet += '</a>';
        htmlSnippet += '</span>';
        htmlSnippet += '</div>';
        htmlSnippet += '<div class="details-more-link" id="details-more-link-' + item.post_id + '" onclick="GNYC.toggleListingDetail(\'' + item.post_id + '\');">';

        if (item.program_description.length > 0 && item.services2.length > 0) {
            htmlSnippet += '<em><i class="fa fa-plus readmoreless"></i> View program details</em>';
        } else {
            htmlSnippet += '<em> No details provided</em>';
        }

        htmlSnippet += '</div>';
        htmlSnippet += '<div class="details-more" id="listing-details-' + item.post_id + '">';
        htmlSnippet += '<p class="program-description">' + item.program_description + '</p>';

        if (item.services2.length > 0) {
            htmlSnippet += '<p class="services-provided"><em>Services provided</em>: ';

            for (var i = 0, isFirst = true; i < item.services2.length; i++) {
                if (item.services2[i].match('(Any)') === null) {
                    if (isFirst) {
                        isFirst = false;
                    } else {
                        htmlSnippet += ', ';
                    }

                    htmlSnippet += item.services2[i];
                }
            }

            htmlSnippet += '</p>';
        }

//        'lessLink': '<i class="fa fa-minus readmoreless"></i> less',
        htmlSnippet += '</div>';

        return htmlSnippet;
    };

    GNYC.googleMapLink = function(item) {
        var baseURL = 'https://www.google.com/maps/place/',
            query = '';

        for (var i = 0; i < GNYC.addressParts.length; i++) {
            if (item[GNYC.addressParts[i][0]][0].trim().length > 0) {
                if (GNYC.addressParts[i][1] === 1) {
                    query += ', ';
                } else if (GNYC.addressParts[i][1] === 2) {
                    query += ' ';
                } else {
                    query += '';
                }

                query += item[GNYC.addressParts[i][0]][0].trim();
            }
        }

        return baseURL + encodeURIComponent(query);
    };

    GNYC.toggleListingDetail = function(post_id) {
        $('#listing-details-' + post_id).toggle();
    };

/*
        htmlSnippet += '<div class="details-more-link" id="details-more-link-' + item.post_id + '" onclick="GNYC.toggleListingDetail(\'' + item.post_id + '\');">';

        if (item.program_description.length > 0 && item.services2.length > 0) {
            htmlSnippet += '<i class="fa fa-plus readmoreless"> View program details</i>';
        }

        htmlSnippet += '</div>';
        htmlSnippet += '<div class="details-more" id="listing-details-' + item.post_id + '">';
        htmlSnippet += '<p class="program-description">' + item.program_description + '</p>';

        if (item.services2.length > 0) {
            htmlSnippet += '<p class="services-provided"><em>Services provided</em>: ';

            for (var i = 0, isFirst = true; i < item.services2.length; i++) {
                if (item.services2[i].match('(Any)') === null) {
                    if (isFirst) {
                        isFirst = false;
                    } else {
                        htmlSnippet += ', ';
                    }

                    htmlSnippet += item.services2[i];
                }
            }

            htmlSnippet += '</p>';
        }

//        'lessLink': '<i class="fa fa-minus readmoreless"></i> less',
//
*/
}


// get filtered data sorted alphabetically in an array
GNYC.objToSortedArray = function(filteredData) {
    var filteredDataArray = [];

    for (var item in filteredData) {
        if (filteredData.hasOwnProperty(item)) {
            filteredDataArray.push(filteredData[item]);
        }
    }

    return filteredDataArray.sort(function(a,b) {
        if (a.program_name < b.program_name) {
            return -1;
        } else if (a.program_name > b.program_name) {
            return 1;
        } else {
            return 0;
        }
    });
};


// Get dataset
GNYC.loadDataset = function() {
    d3.json(GNYC.url.basePath() + '?crc-json=all_listings', function (error, json) {
        if (error) {
            return console.warn(error);
        }

        GNYC.data = json;

        if (GNYC.venue === 'map') {
            GNYC.setBoroughDensity(GNYC.getFilteredData(GNYC.data));
            GNYC.addCBOLocations(GNYC.getFilteredData(GNYC.data));
        } else if (GNYC.venue === 'listings') {
            GNYC.loadListings();
        }
    });
};


// Set filters based on URI
GNYC.processURI = function() {
    if (location.search.length > 0) {
        GNYC.url.parameters = GETURIRequest.decode();

        for (var filter in GNYC.filters) {
            if (GNYC.filters[filter].type === 'checkbox') {
                if (GNYC.url.parameters[filter] === undefined) {
                    GNYC.filters[filter].selected = GNYC.filters[filter].defaultValue;
                } else {
                    GNYC.filters[filter].selected = GNYC.url.parameters[filter];
                }
            } else if (GNYC.filters[filter].type === 'radio') {
                if (GNYC.url.parameters[filter] === undefined) {
                    GNYC.filters[filter].selected = GNYC.filters[filter].defaultValue;
                } else {
                    GNYC.filters[filter].selected = GNYC.url.parameters[filter][0];
                }
            } else {
                console.warn('ERROR: invalid filter type');
            }
        }

        return true;
    } else {
        return false;
    }
}


// Update link to other venue
GNYC.updateLinkToOtherVenue = function() {
    var otherVenue = '',
        baseURL = '',
        query = '?',
        isFirst = true;

    if (GNYC.venue === 'map') {
        otherVenue = 'listings';
    } else if (GNYC.venue === 'listings') {
        otherVenue = 'map';
    }

    baseURL = $('.link-to-' + otherVenue + ' a').attr('href').split('?')[0];

    for (var filter in GNYC.filters) {
        if (GNYC.filters.hasOwnProperty(filter)) {
            if (typeof GNYC.filters[filter].selected === 'string') {
                if (GNYC.filters[filter].selected !== GNYC.filters[filter].defaultValue) {
                    if (isFirst === true) {
                        isFirst = false;
                    } else {
                        query += '&';
                    }

                    query += encodeURIComponent(filter);
                    query += '=';
                    query += encodeURIComponent(GNYC.filters[filter].selected);
                }
            } else {
                for (var i = 0; i < GNYC.filters[filter].selected.length; i++) {
                    if (isFirst === true) {
                        isFirst = false;
                    } else {
                        query += '&';
                    }

                    query += encodeURIComponent(filter);
                    query += '=';
                    query += encodeURIComponent(GNYC.filters[filter].selected[i]);
                }
            }
        }
    }

    $('.link-to-' + otherVenue + ' a').attr('href', baseURL + query);
}


// Create filter form fields
GNYC.createFilterFormFields = function(venue) {
    var fieldSet = {},
        fieldInput = '',
        i = 0;

    if ($.inArray(venue, this.venues) > -1) {
        for (var filter in this.filters) {
            if (GNYC.filters[filter]['on' + venue]) {
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


GNYC.setDefaults = function() {
    for (var filter in GNYC.filters) {
        if (GNYC.filters.hasOwnProperty(filter)) {
            if (GNYC.filters[filter].type === 'checkbox') {
                GNYC.filters[filter].selected = GNYC.filters[filter].defaultValue;
            } else if (GNYC.filters[filter].type === 'radio') {
                GNYC.filters[filter].selected = GNYC.filters[filter].defaultValue;
            } else {
                console.warn('ERROR: INVALID FILTER TYPE: in setDefaults()');
            }
        }
    }
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


GNYC.getFilteredData = function (programsAll) {
    var filteredData = {};

    var includeProgram = function (programToCheck) {
        var isExcluded = {
            'radio': function (thisProgram, thisSelected, thisFilter) {
                // if selected equal to default, don't exclude program
                if (thisSelected === GNYC.filters[thisFilter].defaultValue) {
                    return false;
                // if selected in program, don't exclude program
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
                if (GNYC.filters[filter]['on' + GNYC.venue]) {
                    // rename program, selected, and filter
                    if (isExcluded[GNYC.filters[filter].type](programToCheck,
                                                              GNYC.filters[filter].selected,
                                                              filter)) {
                        return false;
                    }
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


// Update breadcrumbs
GNYC.updateBreadcrumbs = function(thisFilter) {
    var theseBreadcrumbs = $('#' + this.filterToFieldID(thisFilter, 'panel') + ' p.breadcrumbs');

    if (this.filters[thisFilter].type === 'radio') {
        if (this.filters[thisFilter].selected === 'Any') {
            theseBreadcrumbs.html('');
        } else {
            theseBreadcrumbs.html(this.filters[thisFilter].selected);
        }
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

                GNYC.filters[thisFilter].selected = GNYC.filters[thisFilter].selected.slice();

                if (GNYC.venue === 'map') {
                    GNYC.setBoroughDensity(GNYC.getFilteredData(GNYC.data));
                    GNYC.addCBOLocations(GNYC.getFilteredData(GNYC.data));
                } else if (GNYC.venue === 'listings') {
                    GNYC.updateListings();
                }

                GNYC.updateBreadcrumbs(thisFilter);
                GNYC.updateLinkToOtherVenue();
            });
        }
    }
};


// Reset filter to defaults (clear filters)
GNYC.clearFilters = function () {
    GNYC.setDefaults();
    
    GNYC.updateFilterFieldSelections();

    if (GNYC.venue === 'map') {
        GNYC.setBoroughDensity(GNYC.getFilteredData(GNYC.data));
        GNYC.addCBOLocations(GNYC.getFilteredData(GNYC.data));
    } else if (GNYC.venue === 'listings') {
        GNYC.updateListings();
    }
    
    for (var filter in GNYC.filters) {
        GNYC.updateBreadcrumbs(filter);
    }

    GNYC.updateLinkToOtherVenue();
};


$(document).ready(function () {
    // Set global GNYC.venue from GNYC_VENUE global and delete GNYC_VENUE global
    if (window.hasOwnProperty('GNYC_VENUE')) {
        GNYC.venue = GNYC_VENUE;
    }

    // If venue not in GNYC.venues:
    if ($.inArray(GNYC.venue, GNYC.venues) > -1) {
    // Get URI parameters if passed
        // Load data
        GNYC.loadDataset();

        if (GNYC.venue === 'map') {
            GNYC.loadMapBoroughs();
            GNYC.loadMapNeighborhoods();
        }

        // Create form filter fields
        GNYC.createFilterFormFields(GNYC.venue);

        // Update form filters selections
        if (!GNYC.processURI()) {
            GNYC.setDefaults();
        }

        for (var filter in GNYC.filters) {
            GNYC.updateBreadcrumbs(filter);
        }

        GNYC.updateFilterFieldSelections();

        // Create form event listeners
        GNYC.createFormEventListeners();
        GNYC.updateLinkToOtherVenue();

        $(window).resize(function () {
            if (window.innerWidth >= 768) {
                $('#crc-gnsm-listings-form').css('display', 'block');
            }
            if (window.innerWidth < 768) {
                $('#crc-gnsm-listings-form').css('display', 'none');
            }
        });
    } else {
      // DO NOTHING
    }
});


