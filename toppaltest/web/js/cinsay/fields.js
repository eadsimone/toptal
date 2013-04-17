
/**
 * Form field defaults; templates (overrideable by controller)
 * @type {Object}
 */
C.ssm.fields = C.ssm.fields || {
    input: {
        tag: "input",
        type: "text",
        label: "input",
        "class": "input-block-level",
        templatePath: "_common/inputClosedTag.html"
    },
    message: {
        tag: "textarea",
        name: "message",
        label: "message",
        rows: "7",
        placeholder: "Message Text",
        "class": "input-block-level",
        templatePath: "_common/inputWrappedTag.html"
    },
    emailAddresses: {
        tag: "input",
        type: "text",
        label: "Email Address(es)",
        placeholder: "emails",
        "class": "input-block-level",
        templatePath: "_common/inputClosedTag.html"
    },
    playerName: {
        tag: "input",
        type: "text",
        name: "name",
        label: "Player Name",
        placeholder: "Player Name",
        maxlength: 50,
        "class": "input-block-level",
        templatePath: "_common/inputClosedTag.html"
    },
    playerDesc: {
        tag: "textarea",
        name: "playerDescription",
        rows: "4",
        label: "Player description",
        placeholder: "Player Description",
        "class": "input-block-level",
        templatePath: "_common/inputWrappedTag.html"
    },
    playerShareMsg: {
        tag: "textarea",
        name: "share",
        rows: "7",
        label: "Share Message",
        placeholder: "Share Message",
        "class": "input-block-level",
        templatePath: "_common/inputWrappedTag.html"
    },
    playerActive: {
        tag: "input",
        type: "checkbox",
        label: "Active",
        templatePath: "_common/inputClosedTag.html"
    },
    playerEmbed: {
        tag: "textarea",
        rows: "7",
        disabled: "disabled",
        label: "Embed Code",
        "class": "input-block-level",
        templatePath: "_common/inputWrappedTag.html"
    },
    playerSave: {
        tag: "button",
        value: "Save to Player",
        "class": "btn btn-success pull-right",
        templatePath: "_common/inputWrappedTag.html"
    },
    locale: {
        tag: "select",
        label: "Select Locale",
        options: [
            {
                value: "United States",
                name: "United States"
            },
            {
                value: "Mexico",
                name: "Mexico"
            }
        ],
        templatePath: "_common/inputWrappedTag.html"
    },
    btnAddMedia: {
        tag: 'button',
        value: '+',
        label: 'Add Media',
        class: 'btn btn-large',
        templatePath: '_common/inputWrappedTag.html'
    },
    btnAddProducts: {
        tag: 'button',
        value: '+',
        label: 'Add Products',
        class: 'btn btn-large',
        templatePath: "_common/inputWrappedTag.html"
    },
    desc: {
        tag: "textarea",
        label: "Description",
        rows: 4,
        placeholder: "Describe your feelings.",
        "class": "span5",
        templatePath: "_common/inputWrappedTag.html"
    },
    button: {
        tag: "button",
        type: "submit",
        value: "Submit",
        "class": "btn btn-success pull-right",
        templatePath: "_common/inputWrappedTag.html"
    },
    address: {
        tag: "input",
        type: "text",
        name: "address",
        label: "Address",
        placeholder: "Address",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    city: {
        tag: "input",
        type: "text",
        name: "city",
        label: "City",
        placeholder: "City",
        templatePath: '_common/inputClosedTag.html'
    },
    country: {
        tag: "select",
        name: "country",
        label: "Country",
        placeholder: "Country",
        templatePath: '_common/inputWrappedTag.html',
        options: [
            {
                value: "United States",
                name: "United States"
            },
            {
                value: "Mexico",
                name: "Mexico"
            }
        ]
    },
    state: {
        tag: "select",
        name: "state",
        label: "State",
        placeholder: "State",
        templatePath: '_common/inputWrappedTag.html',
        options: [
            {name:"Alabama", value:"Alabama",abbreviation:"AL"},
            {name:"Alaska", value:"Alaska",abbreviation:"AK"},
            {name:"Arizona", value:"Arizona",abbreviation:"AZ"},
            {name:"Arkansas", value:"Arkansas",abbreviation:"AR"},
            {name:"California", value:"California",abbreviation:"CA"},
            {name:"Colorado", value:"Colorado",abbreviation:"CO"},
            {name:"Connecticut", value:"Connecticut",abbreviation:"CT"},
            {name:"Delaware", value:"Delaware",abbreviation:"DE"},
            {name:"District of Columbia", value:"District of Columbia",abbreviation:"DC"},
            {name:"Florida", value:"Florida",abbreviation:"FL"},
            {name:"Georgia", value:"Georgia",abbreviation:"GA"},
            {name:"Hawaii", value:"Hawaii",abbreviation:"HI"},
            {name:"Idaho", value:"Idaho",abbreviation:"ID"},
            {name:"Illinois", value:"Illinois",abbreviation:"IL"},
            {name:"Indiana", value:"Indiana",abbreviation:"IN"},
            {name:"Iowa", value:"Iowa",abbreviation:"IA"},
            {name:"Kansas", value:"Kansas",abbreviation:"KS"},
            {name:"Kentucky", value:"Kentucky",abbreviation:"KY"},
            {name:"Louisiana", value:"Louisiana",abbreviation:"LA"},
            {name:"Maine", value:"Maine",abbreviation:"ME"},
            {name:"Maryland", value:"Maryland",abbreviation:"MD"},
            {name:"Massachusetts", value:"Massachusetts",abbreviation:"MA"},
            {name:"Michigan", value:"Michigan",abbreviation:"MI"},
            {name:"Minnesota", value:"Minnesota",abbreviation:"MN"},
            {name:"Mississippi", value:"Mississippi",abbreviation:"MS"},
            {name:"Missouri", value:"Missouri",abbreviation:"MO"},
            {name:"Montana", value:"Montana",abbreviation:"MT"},
            {name:"Nebraska", value:"Nebraska",abbreviation:"NE"},
            {name:"Nevada", value:"Nevada",abbreviation:"NV"},
            {name:"New Hampshire", value:"New Hampshire",abbreviation:"NH"},
            {name:"New Jersey", value:"New Jersey",abbreviation:"NJ"},
            {name:"New Mexico", value:"New Mexico",abbreviation:"NM"},
            {name:"New York", value:"New York",abbreviation:"NY"},
            {name:"North Carolina", value:"North Carolina",abbreviation:"NC"},
            {name:"North Dakota", value:"North Dakota",abbreviation:"ND"},
            {name:"Ohio", value:"Ohio",abbreviation:"OH"},
            {name:"Oklahoma", value:"Oklahoma",abbreviation:"OK"},
            {name:"Oregon", value:"Oregon",abbreviation:"OR"},
            {name:"Pennsylvania", value:"Pennsylvania",abbreviation:"PA"},
            {name:"Rhode Island", value:"Rhode Island",abbreviation:"RI"},
            {name:"South Carolina", value:"South Carolina",abbreviation:"SC"},
            {name:"South Dakota", value:"South Dakota",abbreviation:"SD"},
            {name:"Tennessee", value:"Tennessee",abbreviation:"TN"},
            {name:"Texas", value:"Texas",abbreviation:"TX"},
            {name:"Utah", value:"Utah",abbreviation:"UT"},
            {name:"Vermont", value:"Vermont",abbreviation:"VT"},
            {name:"Virginia", value:"Virginia",abbreviation:"VA"},
            {name:"Washington", value:"Washington",abbreviation:"WA"},
            {name:"West Virginia", value:"West Virginia",abbreviation:"WV"},
            {name:"Wisconsin", value:"Wisconsin",abbreviation:"WI"},
            {name:"Wyoming", value:"Wyoming",abbreviation:"WY"}
        ]
    },
    zip: {
        tag: "input",
        type: "text",
        name: "zip",
        label: "zip",
        placeholder: "Zip",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    creditCard: {
        tag: "input",
        type: "text",
        name: "creditCard",
        label: "Credit Card",
        placeholder: "Credit Card",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    ccw: {
        tag: "input",
        type: "text",
        name: "ccw",
        label: "CCW",
        placeholder: "CCW",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    monthDropDown: {
        tag: "select",
        name: "months",
        label: "Month",
        templatePath: '_common/inputWrappedTag.html',
        "class": "span2",
        options: [
            { value: "January",name: "January"},
            { value: "February",name: "February"},
            { value: "March",name: "March"},
            { value: "April",name: "April"},
            { value: "May",name: "May"},
            { value: "June",name: "June"},
            { value: "July",name: "July"},
            { value: "August",name: "August"},
            { value: "September",name: "September"},
            { value: "October",name: "October"},
            { value: "November",name: "November"},
            { value: "December",name: "December"}
        ]
    },
    yearDropDown10: {
        tag: "select",
        name: "years",
        label: "Year",
        templatePath: '_common/inputWrappedTag.html',
        "class": "span2",
        options: []
    },
    firstName: {
        tag: "input",
        type: "text",
        name: "firstName",
        label: "First Name",
        placeholder: "First Name",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    lastName: {
        tag: "input",
        type: "text",
        name: "lastName",
        label: "Last Name",
        placeholder: "Last Name",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    email: {
        tag: "input",
        type: "text",
        name: "email",
        label: "Email",
        placeholder: "Email",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    password: {
        tag: "input",
        type: "text",
        name: "password",
        label: "Password",
        placeholder: "Password",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    passwordConf: {
        tag: "input",
        type: "text",
        name: "passwordConf",
        label: "Confirm Password",
        placeholder: "Confirm Password",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    defaultLanguage: {
        tag: "select",
        name: "defaultLanguage",
        label: "Default Language",
        templatePath: '_common/inputWrappedTag.html',
        options: [
            {value: "English",name: "English"},
            {value: "Russian",name: "Russian"}
        ]
    },
    currency: {
        tag: "select",
        name: "currency",
        label: "Currency",
        templatePath: '_common/inputWrappedTag.html',
        options: [
            {value: "USD",name: "USD"}
        ]
    },
    seoURL: {
        tag: "input",
        type: "text",
        name: "seoURL",
        label: "Marketplace SEO URL Suffix",
        placeholder: "URL Suffix",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    marketBio: {
        tag: "input",
        type: "text",
        name: "marketBio",
        label: "Marketplace Bio Headline",
        placeholder: "Bio Headline",
        "class": "input-block-level",
        templatePath: '_common/inputClosedTag.html'
    },
    marketBioText: {
        tag: "textarea",
        rows: "4",
        name: "marketBioText",
        label: "Marketplace Bio Text",
        "class": "input-block-level",
        templatePath: '_common/inputWrappedTag.html'
    },
    pwo: {
        name: {
            tag: "input",
            type: "text",
            name: "options[name][]",
            "class": "option-name input-small",
            placeholder: "Name",
            templatePath: "_common/inputClosedTag.html"
        },
        sku: {
            tag: "input",
            type: "text",
            name: "options[sku][]",
            "class": "option-sku input-mini",
            placeholder: "SKU",
            templatePath: "_common/inputClosedTag.html"
        },
        price: {
            tag: "input",
            type: "text",
            name: "options[price][]",
            "class": "option-price input-mini",
            placeholder: "Price",
            templatePath: "_common/inputClosedTag.html"
        },
        quantity: {
            tag: "input",
            type: "text",
            name: "options[quantity][]",
            "class": "option-quantity input-mini",
            placeholder: "Qty.",
            templatePath: "_common/inputClosedTag.html"
        },
        weight: {
            tag: "input",
            type: "text",
            name: "options[weight][]",
            "class": "option-weight input-mini",
            placeholder: "Weight",
            templatePath: "_common/inputClosedTag.html"
        }
    }

};

var d = new Date(), thisYear = d.getFullYear();
for( i = thisYear; i <= (thisYear+10); i++ ) {
    C.ssm.fields.yearDropDown10.options.push( { name: i, value: i } );
}