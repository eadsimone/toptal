/*globals jQuery*/

/**
 * Module ServiceBusDataAdapter.
 * Offer the functionality to convert the data retrieved from the Service Bus
 * service response, to make them compatible with the different kind of charts.
 */
var ServiceBusDataAddapter = (function ($) {
    'use strict';

    var mapNames = {
        'world': {
            'af': "Afghanistan",
            'al': "Albania",
            'dz': "Algeria",
            'as': "American Samoa",
            'ad': "Andorra",
            'ao': "Angola",
            'ai': "Antigua and Barbuda",
            'ar': "Argentina",
            'am': "Armenia",
            'aw': "Aruba",
            'au': "Australia",
            'at': "Austria",
            'az': "Azerbaijan",
            'bs': "The Bahamas",
            'bh': "Bahrain",
            'bd': "Bangladesh",
            'bb': "Barbados",
            'by': "Belarus",
            'be': "Belgium",
            'bz': "Belize",
            'bj': "Benin",
            //'bm': "Bermuda",
            'bt': "Bhutan",
            'bo': "Bolivia",
            'ba': "Bosnia and Herzegovina",
            'bw': "Botswana",
            'br': "Brazil",
            'bn': "Brunei Darussalam",
            'bg': "Bulgaria",
            'bf': "Burkina Faso",
            'bi': "Burundi",
            'kh': "Cambodia",
            'cm': "Cameroon",
            'ca': "Canada",
            //'cv': "Cape Verde",
            'ky': "Cayman Islands",
            'cf': "Central African Republic",
            'td': "Chad",
            'cl': "Chile",
            'cn': "China",
            'co': "Colombia",
            //'km': "Comoros",
            'cd': "Congo Dem. Rep.",
            'cg': "Congo Rep.",
            'cr': "Costa Rica",
            'ci': "Cote d'Ivoire",
            'hr': "Croatia",
            'cu': "Cuba",
            //'cw': "Curacao",
            'cy': "Cyprus",
            'cz': "Czech Republic",
            'dk': "Denmark",
            'dj': "Djibouti",
            'dm': "Dominica",
            'do': "Dominican Republic",
            'ec': "Ecuador",
            'eg': "Egypt, Arab Rep.",
            'sv': "El Salvador",
            'gq': "Equatorial Guinea",
            'er': "Eritrea",
            'ee': "Estonia",
            'et': "Ethiopia",
            //'fo': "Faeroe Islands",
            'fj': "Fiji",
            'fi': "Finland",
            'fr': "France",
            //'pf': "French Polynesia",
            'ga': "Gabon",
            'gm': "The Gambia",
            'ge': "Georgia",
            'de': "Germany",
            'gh': "Ghana",
            'gr': "Greece",
            'gl': "Greenland",
            'gd': "Grenada",
            //'gu': "Guam",
            'gt': "Guatemala",
            'gn': "Guinea",
            'gw': "Guinea-Bissau",
            'gy': "Guyana",
            'ht': "Haiti",
            'hn': "Honduras",
            'hk': "Hong Kong SAR, China",
            'hu': "Hungary",
            'is': "Iceland",
            'in': "India",
            'id': "Indonesia",
            'ir': "Iran, Islamic Rep.",
            'iq': "Iraq",
            'ie': "Ireland",
            //'im': "Isle of Man",
            'il': "Israel",
            'it': "Italy",
            'jm': "Jamaica",
            'jp': "Japan",
            'jo': "Jordan",
            'kz': "Kazakhstan",
            'ke': "Kenya",
            //'ki': "Kiribati",
            'kp': "Korea Dem. Rep.",
            'kr': "Korea Rep.",
            //'xk': "Kosovo",
            'kw': "Kuwait",
            'kg': "Kyrgyz Republic",
            'la': "Lao PDR",
            'lv': "Latvia",
            'lb': "Lebanon",
            'ls': "Lesotho",
            'lr': "Liberia",
            'ly': "Libya",
            //'li': "Liechtenstein",
            'lt': "Lithuania",
            'lu': "Luxembourg",
            //'mo': "Macao SAR, China",
            'mk': "Macedonia, FYR",
            'mg': "Madagascar",
            'mw': "Malawi",
            'my': "Malaysia",
            //'mv': "Maldives",
            'ml': "Mali",
            'mt': "Malta",
            //'mh': "Marshall Islands",
            'mr': "Mauritania",
            //'mu': "Mauritius",
            //'yt': "Mayotte",
            'mx': "Mexico",
            //'fm': "Micronesia Fed. Sts.",
            'md': "Moldova",
            'mc': "Monaco",
            'mn': "Mongolia",
            'me': "Montenegro",
            'ma': "Morocco",
            'mz': "Mozambique",
            'mm': "Myanmar",
            'na': "Namibia",
            'np': "Nepal",
            'nl': "Netherlands",
            'nc': "New Caledonia",
            'nz': "New Zealand",
            'ni': "Nicaragua",
            'ne': "Niger",
            'ng': "Nigeria",
            //'mp': "Northern Mariana Islands",
            'no': "Norway",
            'om': "Oman",
            'pk': "Pakistan",
            //'pw': "Palau",
            'pa': "Panama",
            'pg': "Papua New Guinea",
            'py': "Paraguay",
            'pe': "Peru",
            'ph': "Philippines",
            'pl': "Poland",
            'pt': "Portugal",
            'pr': "Puerto Rico",
            'wa': "Qatar",
            'ro': "Romania",
            'ru': "Russian Federation",
            'rw': "Rwanda",
            //'ws': "Samoa",
            //'sm': "San Marino",
            //'st': "Sao Tome and Principe",
            'sa': "Saudi Arabia",
            'sn': "Senegal",
            'rs': "Serbia",
            //'sc': "Seychelles",
            'sl': "Sierra Leone",
            'sg': "Singapore",
            'sk': "Slovak Republic",
            'si': "Slovenia",
            'sb': "Solomon Islands",
            'so': "Somalia",
            'za': "South Africa",
            //'ss': "South Sudan",
            'es': "Spain",
            'lk': "Sri Lanka",
            //'kn': "St. Kitts and Nevis",
            'lc': "St. Lucia",
            //'mf': "St. Martin (French part)",
            'vc': "St. Vincent and the Grenadines",
            'sd': "Sudan",
            'sr': "Suriname",
            'sz': "Swaziland",
            'se': "Sweden",
            'ch': "Switzerland",
            'sy': "Syrian Arab Republic",
            'tj': "Tajikistan",
            'tz': "Tanzania",
            'th': "Thailand",
            //'tp': "Timor-Leste",
            'tg': "Togo",
            'to': "Tonga",
            'tt': "Trinidad and Tobago",
            'tn': "Tunisia",
            'tr': "Turkey",
            'tm': "Turkmenistan",
            //'tc': "Turks and Caicos Islands",
            //'tv': "Tuvalu",
            'ug': "Uganda",
            'ua': "Ukraine",
            'ae': "United Arab Emirates",
            'uk': "United Kingdom",
            'us': "United States",
            'uy': "Uruguay",
            'uz': "Uzbekistan",
            'vu': "Vanuatu",
            've': "Venezuela, RB",
            'vn': "Vietnam",
            //'vi': "Virgin Islands (U.S.)",
            //'ps': "West Bank and Gaza",
            'eh': "Western Sahara",
            'ye': "Yemen, Rep.",
            'zm': "Zambia",
            'zw': "Zimbabwe ",
            'ag': "ag",
            'an': "an",
            'ax': "ax",
            'fk': "fk",
            'gf': "gf",
            'gi': "gi",
            'gp': "gp",
            'hm': "hm",
            'mq': "mq",
            'ms': "ms",
            'qa': "qa",
            'tf': "tf",
            'tl': "tl",
            'tw': "tw",
            'wf': "wf"
        },

        /**
         * U.S. state code-name mapping, to show in the map charts
         */
        'us':  {
            "al": "Alabama",
            "az": "Arizona",
            "ar": "Arkansas",
            "ca": "California",
            "co": "Colorado",
            "ct": "Connecticut",
            "de": "Delaware",
            "dc": "District of Columbia",
            "fl": "Florida",
            "ga": "Georgia",
            "id": "Idaho",
            "il": "Illinois",
            "in": "Indiana",
            "ia": "Iowa",
            "ks": "Kansas",
            "ky": "Kentucky",
            "la": "Louisiana",
            "me": "Maine",
            "md": "Maryland",
            "ma": "Massachusetts",
            "mi": "Michigan",
            "mn": "Minnesota",
            "ms": "Mississippi",
            "mo": "Missouri",
            "mt": "Montana",
            "ne": "Nebraska",
            "nv": "Nevada",
            "nh": "New Hampshire",
            "nj": "New Jersey",
            "nm": "New Mexico",
            "ny": "New York",
            "nc": "North Carolina",
            "nd": "North Dakota",
            "oh": "Ohio",
            "ok": "Oklahoma",
            "or": "Oregon",
            "pa": "Pennsylvania",
            "ri": "Rhode Island",
            "sc": "South Carolina",
            "sd": "South Dakota",
            "tn": "Tennessee",
            "tx": "Texas",
            "ut": "Utah",
            "vt": "Vermont",
            "va": "Virginia",
            "wa": "Washington",
            "wv": "West Virginia",
            "wi": "Wisconsin",
            "wy": "Wyoming"
        }
    };

    /**
     * Generates a title to be used in chart legends or any other suitable place
     * where from a camel-cased key, a title must be displayed.
     *
     */
    var _generateSmartTitle = function (camelCasedStr, lookupTranslationArray) {
        var title = null;

        if (typeof lookupTranslationArray !== 'undefined') {
            title = typeof lookupTranslationArray[camelCasedStr] !== 'undefined' ? lookupTranslationArray[camelCasedStr] : null;
            if (title === null) {
                title = __(camelCasedStr);
            }
            title = $.trim(title);
        }

        if (title === null || title.length === 0) {
            title = camelCasedStr.replace(/([A-Z])/g, " $1");
            title = $.trim(title);
            if (title.length > 0) {
                title = title[0].toUpperCase() + title.substr(1);
            } else {
                title = "Unknown";
            }
        }

        return title;
    };

    var _isArray = function (variable) {
        return Object.prototype.toString.call(variable) === '[object Array]';
    };

    /**
     * Converts the data retrieved from the Service Bus service response to make
     * them compatible with the used in Area charts.
     */
    var _adaptAreaChartData = function (rawData, colorMapping, dateFrom, dateTo) {
        var createFillDataItem = function (xValue) {
            var dataItem = { x: xValue };
            for (var propIndex = 0; propIndex < seriesNames.length; propIndex++) {
                var propName = seriesNames[propIndex];
                dataItem[propName] = 0;
            }
            return dataItem;
        };

        var formatDate = function (day, month, year) {
            var dateStr = year.toString() + "-";
            dateStr += (month < 10 ? "0" : "") + month.toString() + "-";
            dateStr += (day < 10 ? "0" : "") + day.toString();
            return dateStr;
        }

        var addDay = function (dateStr, numDays) {
            var dateParts = dateStr.match(/^(\d\d\d\d)-(\d\d)-(\d\d)$/);
            var year  = parseInt(dateParts[1], 10);
            var month = parseInt(dateParts[2], 10);
            var day   = parseInt(dateParts[3], 10);
            var monthDays = [31, 28 + (year % 4 === 0 ? 1 : 0), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            day++;
            if (day > monthDays[month - 1]) {
                day = 1;
                month++;
                if (month > 12) {
                    month = 1;
                    year++;
                }
            }

            return formatDate(day, month, year);
        };

        var len = 0, seriesNames = [], xAxisName = null;
        for (var seriesKey in rawData) if (rawData.hasOwnProperty(seriesKey)) {
            if (seriesKey.toLowerCase() === 'x-axis') {
                xAxisName = seriesKey;
            } else {
                seriesNames.push(seriesKey);
            }
            if (rawData[seriesKey] === null) {
                rawData[seriesKey] = [];
            }
            len = rawData[seriesKey].length > len ? rawData[seriesKey].length : len;
        }

        if (seriesNames.length === 0) {
            rawData['noData'] = [];
            seriesNames.push('noData');
        }

        if (xAxisName === null) {
            xAxisName = 'x-axis';
            rawData[xAxisName] = [];
        }

        var dataItems = [];
        for (var i = 0; i < len; i++) {
            var dataItem = { x: rawData[xAxisName][i] };
            for (var propIndex = 0; propIndex < seriesNames.length; propIndex++) {
                var propName = seriesNames[propIndex];
                if (rawData[propName] === null) {
                    dataItem[propName] = 0;
                }else{
                    dataItem[propName] = rawData[propName][i];
                }
            }
            dataItems.push(dataItem);
        }
        dataItems.sort(function (value1, value2) {
            var v1 = value1.x;
            var v2 = value2.x;
            return v1 <= v2 ? -1 : 1;
        });

        var emptyDataSet = dataItems.length === 0;
        // Fill date at the beginning
        if (emptyDataSet || dataItems[0].x > dateFrom) {
            dataItems.unshift(createFillDataItem(dateFrom));
            len++;
        }
        // Fill date at the end
        if (emptyDataSet || dataItems[dataItems.length - 1].x < dateTo) {
            dataItems.push(createFillDataItem(dateTo));
            len++;
        }

        var currentDateStr = dataItems[0].x;
        var expectedDateStr = currentDateStr;
        var filledDataItems = [];
        for (i = 0; i < len; i++) {
            dataItem = dataItems[i];
            currentDateStr = dataItem.x;

            // Fill inner dates
            while (expectedDateStr < currentDateStr) {
                filledDataItems.push(createFillDataItem(expectedDateStr));
                expectedDateStr = addDay(expectedDateStr);
            }

            filledDataItems.push(dataItem);
            expectedDateStr = addDay(currentDateStr);
        }

        var seriesData = {};
        for (i = 0; i < filledDataItems.length; i++) {
            dataItem = filledDataItems[i];
            for (propIndex = 0; propIndex < seriesNames.length; propIndex++) {
                propName = seriesNames[propIndex];
                if (typeof seriesData[propName] === 'undefined') {
                    seriesData[propName] = [dataItem[propName]];
                } else {
                    seriesData[propName].push(dataItem[propName]);
                }
            }
        }

        var adaptedData = [];
        for (propIndex = 0; propIndex < seriesNames.length; propIndex++) {
            seriesKey = seriesNames[propIndex];
            var areaSeriesName = _generateSmartTitle(seriesKey, translationLookup);

            adaptedData.push({
                key: areaSeriesName,
                data: seriesData[seriesKey],
                lineColor: typeof colorMapping !== 'undefined' && typeof colorMapping[seriesKey] !== 'undefined' ? colorMapping[seriesKey] : 'black'
            });
        }

        return adaptedData;
    };

    /**
     * Converts the data retrieved from the Service Bus service response to make
     * them compatible with the used in Horizontal Bar charts.
     */
    var _adaptHBarChartData = function (rawData, chartName) {
        var keyPropName = 'hostedSite';
        var countPropName = 'numberViews';

        if (chartName == 'playerTopSocialSites') { // change properties to look for if not the default bar chart
        	keyPropName = 'socialSite';
        	countPropName = 'totalShares';
        }

        // If there is no data, we create a default "No Data" entry
        if (!rawData.hasOwnProperty(countPropName)) {
            rawData[keyPropName] = [_generateSmartTitle('noData', translationLookup)];
            rawData[countPropName] = [0];
        }

        var adaptedData = [];
        var keys = rawData[keyPropName];
        var values = rawData[countPropName];

        for (var i = 0; i < keys.length; i++) {
                var label = _generateSmartTitle(keys[i], translationLookup);
                var newValue = parseInt(values[i], 10);
                adaptedData.push({
                    label: label,
                    value: newValue.toString() === "NaN" ? 0 : newValue
                });

        }

        return adaptedData;
    };

    /**
     * Converts the data retrieved from the Service Bus service response to make
     * them compatible with the used in Map charts.
     *
     * Supported formats:
     * - Case 1: Only one item
     *     {numberViews: 4195, province: "TX"}
     * - Case 2: Collection of items splitted up by state code and count
     *     {numberViews: [4195, 222], province:["TX","ar"]}
     * - Case 3: Collection of items
     *     [{numberViews: 4195,province: "TX"}, {numberViews: 222,province: "ar"}]
     *
     * * The count property (numberViews in the examples above) is guessed.
     *   The firt property named number* will be used. For example, numberView,
     *   numberShares, numberTransactions.
     *
     * * Values can be number or string representing numbers.
     *
     * * Null or invalid values are supported and interpreted as 0.
     *
     * * State codes are case insensitive.
     *
     * * Unknown state codes are ignored.
     */
    var _adaptMapChartData = function (rawData, mapType) {
        var mapSectionsMapping = typeof mapType !== 'undefined' ? mapNames[mapType] : {};

        var values = {}, stateCode, value, i;
        for (stateCode in mapSectionsMapping) if (mapSectionsMapping.hasOwnProperty(stateCode)) {
            values[stateCode] = 0;
        }

        var guessCountPropertyName = function (rawData) {
            var dataObject = _isArray(rawData) && rawData.length > 0 ? rawData[0] : rawData;
            for (var propName in dataObject) if (dataObject.hasOwnProperty(propName)) {
                if (propName !== 'province') {
                    return propName;
                }
            }
            return 'numberViews';
        };
        var countPropName = guessCountPropertyName(rawData);

        if (!_isArray(rawData) && typeof rawData !== 'undefined' && rawData !== null && rawData.hasOwnProperty('province')) {
            if (!_isArray(rawData.province)) { // Case 1
                rawData.province = [rawData.province];
                rawData[countPropName] = [rawData[countPropName]];
            }

            var count = Math.min(rawData.province.length, rawData[countPropName].length);

            for (i = 0; i < count; i++) { // Case 2
                stateCode = rawData.province[i].toLowerCase();
                value = parseFloat(rawData[countPropName][i]);
                value = value.toString() === "NaN" ? 0 : value;
                if (values.hasOwnProperty(stateCode)) {
                    values[stateCode] = value;
                }
            }
        } else if (_isArray(rawData)) {
            for (i = 0; i < rawData.length; i++) { // Case 3
                var dataItem = rawData[i];
                stateCode = dataItem.province.toLowerCase();
                value = parseInt(dataItem[rawData[countPropName]], 10);
                value = value.toString() === "NaN" ? 0 : value;
                if (values.hasOwnProperty(stateCode)) {
                    values[stateCode] = value;
                }
            }
        }

        var adaptedData = [];
        for (var seriesKey in values) {
            if (values.hasOwnProperty(seriesKey)) {
                var newValue = parseFloat(values[seriesKey]);
                var stateName = _generateSmartTitle(seriesKey, mapSectionsMapping);
                adaptedData.push({
                    key: seriesKey,
                    title: stateName,
                    value: newValue.toString() === "NaN" ? 0 : newValue
                });
            }
        }

        return adaptedData;
    };

    /**
     * Converts the data retrieved from the Service Bus service response to make
     * them compatible with the used in Ratios charts.
     */
    var _adaptRatiosChartData = function (rawData) {
        var adaptedData = {};
        for (var seriesKey in rawData) {
            if (rawData.hasOwnProperty(seriesKey)) {
                var ratioName = _generateSmartTitle(seriesKey, translationLookup);
                adaptedData[seriesKey] = {
                    key: seriesKey,
                    title: ratioName,
                    value: rawData[seriesKey] !== null ? rawData[seriesKey] : 0
                };
            }
        }

        return adaptedData;
    };

    /**
     * Converts the data retrieved from the Service Bus service response to make
     * them compatible with the used in Pie charts.
     */
    var _adaptPieChartData = function (rawData) {
        var adaptScalar = function (rawSeriesData) {
            var adaptedSeriesData = [];
            var allZeroValues = true;

            for (var seriesKey in rawSeriesData) {
                if (rawSeriesData.hasOwnProperty(seriesKey)) {
                    var serieName = _generateSmartTitle(seriesKey, translationLookup);
                    var newValue = parseFloat(rawSeriesData[seriesKey]);
                    newValue = newValue.toString() === 'NaN' ? 0 : newValue;
                    if (newValue > 0) {
                        allZeroValues = false;
                    }
                    adaptedSeriesData.push([
                        serieName,
                        newValue
                    ]);
                }
            }
            if (allZeroValues) {
                adaptedSeriesData.push([_generateSmartTitle('noData', translationLookup), 1]);
            }
            return adaptedSeriesData;
        };

        var adaptBrowserCollection = function (rawSeriesData) {
            var adaptedSeriesData = [];
            var allZeroValues = true;

            var i, itemCount = typeof rawSeriesData.count !== 'undefined' ? rawSeriesData.count.length : 0;
            var dataSummary = {};
            for (i = 0; i < itemCount; i++) {
                var rawSeriesDataItem = {
                    browserVendor: (function () {
                        if (typeof rawSeriesData.browserVendor === 'undefined' || rawSeriesData.browserVendor[i] === 'undefined' || rawSeriesData.browserVendor[i] === null) return null;
                        var vendor = rawSeriesData.browserVendor[i];
                        if (typeof vendor === 'string') {
                            vendor = $.trim(vendor.toString());
                            vendor = vendor.length === 0 ? null : vendor;
                            return vendor;
                        }
                        return null
                    }()),
                    browserVersion: (function () {
                        if (typeof rawSeriesData.browserVersion === 'undefined' || rawSeriesData.browserVersion[i] === 'undefined' || rawSeriesData.browserVersion[i] === null) return null;
                        var version = rawSeriesData.browserVersion[i];
                        if (typeof version === 'string' || typeof version === 'number') {
                            version = $.trim(version.toString());
                            version = version.replace(/^(\d*).*/g, '$1'); // Takes just the major part of the version, so Chrome 10.2.3 and Chrome 10.1.5 are converted to Chrome 10.
                            version = version.length === 0 ? null : version;
                            return version;
                        }
                        return null;
                    }()),
                    count: rawSeriesData.count[i]
                }

                var browser = rawSeriesDataItem.browserVendor !== null ? rawSeriesDataItem.browserVendor : "Unknown browser";
                browser += rawSeriesDataItem.browserVersion !== null ? " " + rawSeriesDataItem.browserVersion : "";
                var count = rawSeriesDataItem.count !== null ? rawSeriesDataItem.count : 0;
                dataSummary[browser] = dataSummary.hasOwnProperty(browser) ? dataSummary[browser] + count : count;
            }
            for (browser in dataSummary) if (dataSummary.hasOwnProperty(browser)) {
                var newValue = dataSummary[browser];
                if (newValue > 0) {
                    allZeroValues = false;
                }
                adaptedSeriesData.push([browser, newValue]);
            }
            if (allZeroValues) {
                adaptedSeriesData.push([_generateSmartTitle('noData', translationLookup), 1]);
            }

            return adaptedSeriesData;
        };

        var adaptOsCollection = function (rawSeriesData) {
            var adaptedSeriesData = [];
            var allZeroValues = true;

            var i, itemCount = typeof rawSeriesData.count !== 'undefined' ? rawSeriesData.count.length : 0;
            var dataSummary = {};
            for (i = 0; i < itemCount; i++) {
                var rawSeriesDataItem = {
                    osPlatform: (function () {
                        if (typeof rawSeriesData.osPlatform === 'undefined' || typeof rawSeriesData.osPlatform[i] === 'undefined') return null;
                        var os = rawSeriesData.osPlatform[i];
                        if (typeof os === 'string') {
                            os = $.trim(os);
                            os = os.length === 0 ? null : os;
                        } else {
                            os = null;
                        }
                        return os;
                    }()),
                    count: rawSeriesData.count[i]
                }

                var os = rawSeriesDataItem.osPlatform !== null ? rawSeriesDataItem.osPlatform : "Unknown OS";
                var count = rawSeriesDataItem.count !== null ? rawSeriesDataItem.count : 0;
                dataSummary[os] = dataSummary.hasOwnProperty(os) ? dataSummary[os] + count : count;
            }
            for (os in dataSummary) if (dataSummary.hasOwnProperty(os)) {
                var newValue = dataSummary[os];
                if (newValue > 0) {
                    allZeroValues = false;
                }
                adaptedSeriesData.push([os, newValue]);
            }
            if (allZeroValues) {
                adaptedSeriesData.push([_generateSmartTitle('noData', translationLookup), 1]);
            }

            return adaptedSeriesData;
        };

        var extractOneOwnProperty = function (object) {
            for (var prop in object) {
                if (object.hasOwnProperty(prop)) {
                    return prop;
                }
            }
            return null;
        };

        var adaptedData = [];
        for (var i = 0; i < rawData.length; i++) {
            var rawSeriesData = rawData[i], adaptedSeriesData = null;

            var propName = extractOneOwnProperty(rawSeriesData);
            if (propName !== null) {
                if (_isArray(rawSeriesData[propName])) {
                    if (rawSeriesData.hasOwnProperty('browserVendor')) {
                        adaptedSeriesData = adaptBrowserCollection(rawSeriesData);
                    } else {
                        adaptedSeriesData = adaptOsCollection(rawSeriesData);
                    }
                } else {
                    adaptedSeriesData = adaptScalar(rawSeriesData);
                }
            } else {
                adaptedSeriesData = adaptScalar(rawSeriesData);
            }

            adaptedData.push(adaptedSeriesData);
        }

        return adaptedData;
    };

    /**
     * Converts the actual data from this
     * series: [{
     *   name: 'Direct / Viral',
     *   data: [[_chartData[0]['name'], _chartData[0]['data'][0]],[_chartData[2]['name'],_chartData[2]['data'][0]]]
     *   },{
     *   name: 'Direct / Viral',
     *   data: [[_chartData[1]['name'], _chartData[1]['data'][0]],[_chartData[3]['name'],_chartData[3]['data'][0]]]
     *   }]
     *  To adapt it dynamically for Direct vs Viral Chart
     */
    var _reFormatData = function (data) {
        var newFormatData = [];
        var i = 0;
        var columnData = [];
        while (i < data.length/2) {
            newFormatData[i] = {};
            newFormatData[i]['name'] = 'Direct / Viral';
            columnData = [];
            columnData[0] = [];
            columnData[0][0] = data[i]['name'];
            columnData[0][1] = data[i]['data'][0];
            columnData[1] = [];
            columnData[1][0] = data[i+2]['name'];
            columnData[1][1] = data[i+2]['data'][0];
            newFormatData[i]['data'] = [];
            newFormatData[i]['data'] = columnData;
            i++;
        }

        return newFormatData;

    };

    /**
     * Converts the data retrieved from the Service Bus service response to make
     * them compatible with the used in Column charts.
     */
    var _adaptColumnChartData = function (rawData) {
        var adaptedToObjectData = {}, seriesKey;

        for (var seriesIndex = 0; seriesIndex < rawData.length; seriesIndex++) {
            var rawSeriesData = rawData[seriesIndex];

            for (seriesKey in rawSeriesData) {
                if (rawSeriesData.hasOwnProperty(seriesKey)) {
                    var value = parseFloat(rawSeriesData[seriesKey]);
                    value = value.toString() === 'NaN' ? 0 : value;
                    if (adaptedToObjectData.hasOwnProperty(seriesKey)) {
                        adaptedToObjectData[seriesKey].push(value);
                    } else {
                        adaptedToObjectData[seriesKey] = [value];
                    }
                }
            }
        }

        var adaptedData = [];
        for (seriesKey in adaptedToObjectData) {
            if (adaptedToObjectData.hasOwnProperty(seriesKey)) {
                adaptedData.push({
                    name: _generateSmartTitle(seriesKey, translationLookup),
                    data: adaptedToObjectData[seriesKey]
                });
            }
        }

        return adaptedData;
    };

    return {
        // Public methods
        addaptAreaChartData   : _adaptAreaChartData,
        addaptHBarChartData   : _adaptHBarChartData,
        addaptMapChartData    : _adaptMapChartData,
        addaptRatiosChartData : _adaptRatiosChartData,
        addaptPieChartData    : _adaptPieChartData,
        addaptColumnChartData : _adaptColumnChartData,
        reFormatData          : _reFormatData
    };

}(jQuery));