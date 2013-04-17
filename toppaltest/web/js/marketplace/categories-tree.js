/*
Mockup data structure:

a
+-a-a
| `-a-a-a
|   +-a-a-a-a
|   +-a-a-a-b
|   +-a-a-a-c
|   | +-a-a-a-c-a
|   | +-a-a-a-c-b
|   | `-a-a-a-c-c
|   `-a-a-a-d
b
+-b-a
+-b-b
c
|-c-a
| +-c-a-a
| | +-c-a-a-b
| | `-c-a-a-c
| +-c-a-b
| | +-c-a-b-a
| | +-c-a-b-b
| | `-c-a-b-c
| `-c-a-c
|   `-c-a-c-a
+-c-b
`-c-c
  +-c-c-a
  `-c-c-b
*/

/*var categories = [
    {label:"a",value:1,children:[
        {label:"a-a",value:2,children:[
            {label:"a-a-a",value:3,children:[
                {label:"a-a-a-a",value:4},
                {label:"a-a-a-b",value:5},
                {label:"a-a-a-c",value:6,children:[
                    {label:"a-a-a-c-a",value:7},
                    {label:"a-a-a-c-b",value:8},
                    {label:"a-a-a-c-c",value:9}
                ]},
                {label:"a-a-a-d",value:10}
            ]}
        ]}
    ]},
    {label:"b",value:11,children:[
        {label:"b-a",value:12},
        {label:"b-b",value:13}
    ]},
    {label:"c",value:14,children:[
        {label:"c-a",value:15,children:[
            {label:"c-a-a",value:16,children:[
                {label:"c-a-a-b",value:17},
                {label:"c-a-a-c",value:18}
            ]},
            {label:"c-a-b",value:19,children:[
                {label:"c-a-b-a",value:20},
                {label:"c-a-b-b",value:21},
                {label:"c-a-b-c",value:22}
            ]},
            {label:"c-a-c",value:23,children:[
                {label:"c-a-c-a",value:24}
            ]}
        ]},
        {label:"c-b",value:25},
        {label:"c-c",value:26,children:[
            {label:"c-c-a",value:27},
            {label:"c-c-b",value:28}
        ]}
    ]}
];*/

var categoriesTree = [
    {
        label:"a",
        desc:"a",
        value:1,
        children:[{
            label:"a-a",
            desc:"a > a-a",
            value:2,
            children:[{
                label:"a-a-a",
                desc:"a > a-a > a-a-a",
                value:3,
                children:[{
                    label:"a-a-a-a",
                    desc:"a > a-a > a-a-a > a-a-a-a (no children)",
                    value:4
                },{
                    label:"a-a-a-b",
                    desc:"a > a-a > a-a-a > a-a-a-b (no children)",
                    value:5
                },{
                    label:"a-a-a-c",
                    desc:"a > a-a > a-a-a > a-a-a-c",
                    value:6,
                    children:[{
                        label:"a-a-a-c-a",
                        desc:"a > a-a > a-a-a > a-a-a-c > a-a-a-c-a (no children)",
                        value:7
                    },{
                        label:"a-a-a-c-b",
                        desc:"a > a-a > a-a-a > a-a-a-c > a-a-a-c-b (no children)",
                        value:8
                    },{
                        label:"a-a-a-c-c",
                        desc:"a > a-a > a-a-a > a-a-a-c > a-a-a-c-c (no children)",
                        value:9
                    }]
                },{
                    label:"a-a-a-d",
                    desc:"a > a-a > a-a-a > a-a-a-d (no children)",
                    value:10
                }]
            }]
        }]
    },
    {
        label:"b",
        desc:"b",
        value:11,
        children:[{
            label:"b-a",
            desc:"b > b-a (no children)",
            value:12
        },{
            label:"b-b",
            desc:"b > b-b (no children)",
            value:13
        }]
    },
    {
        label:"c",
        desc:"c",
        value:14,
        children:[{
            label:"c-a",
            desc:"c > c-a",
            value:15,
            children:[{
                label:"c-a-a",
                desc:"c > c-a > c-a-a",
                value:16,
                children:[{
                    label:"c-a-a-b",
                    desc:"c > c-a > c-a-a > c-a-a-b (no children)",
                    value:17
                },{
                    label:"c-a-a-c",
                    desc:"c > c-a > c-a-a > c-a-a-c (no children)",
                    value:18
                }]
            },{
                label:"c-a-b",
                desc:"c > c-a > c-a-b",
                value:19,
                children:[{
                    label:"c-a-b-a",
                    desc:"c > c-a > c-a-b > c-a-b-a (no children)",
                    value:20
                },{
                    label:"c-a-b-b",
                    desc:"c > c-a > c-a-b > c-a-b-b (no children)",
                    value:21
                },{
                    label:"c-a-b-c",
                    desc:"c > c-a > c-a-b > c-a-b-c (no children)",
                    value:22
                }]
            },{
                label:"c-a-c",
                desc:"c > c-a > c-a-c",
                value:23,
                children:[{
                    label:"c-a-c-a",
                    desc:"c > c-a > c-a-c > c-a-c-a (no children)",
                    value:24
                }]
            }]
        },{
            label:"c-b",
            desc:"c > c-b (no children)",
            value:25
        },{
            label:"c-c",
            desc:"c > c-c",
            value:26,
            children:[{
                label:"c-c-a",
                desc:"c > c-c > c-c-a (no children)",
                value:27
            },{
                label:"c-c-b",
                desc:"c > c-c > c-c-b (no children)",
                value:28
            }]
        }]
    }
];


categoriesTree = [
    {
        value: 1,
        label: "Nature",
        children: [{
            value: 2,
            label: "Animals",
            children: [{
                value: 3,
                label: "Domestic",
                children: [{
                    value: 4,
                    label: "Dog"
                },{
                    value: 5,
                    label: "Cat"
                }]
            },{
                value: 6,
                label: "Wild",
                children: [{
                    value: 61,
                    label: "Lion"
                },{
                    value: 62,
                    label: "Zebra"
                },{
                    value: 63,
                    label: "Tiger"
                }]
            }]
        },{
            value: 7,
            label: "Plants"
        },{
            value: 8,
            label: "Minerals"
        },{
            value: 9,
            label: "Research"
        }]
    },{
        value: 10,
        label: "Technology",
        children: [{
            value: 11,
            label: "Hardware",
            children: [{
                value: 111,
                label: "Work Machines"
            },{
                value: 112,
                label: "Computer Periferals"
            },{
                value: 113,
                label: "Robots"
            }]
        },{
            value: 12,
            label: "Software",
            children: [{
                value: 13,
                label: "Web Development"
            },{
                value: 14,
                label: "Research"
            },{
                value: 15,
                label: "System Architecture"
            },{
                value: 16,
                label: "Design Patterns"
            }]
        },{
            value: 17,
            label: "Research"
        }]
    },{
        value: 18,
        label: "Arts",
        children: [{
            value: 19,
            label: "Music",
            children: [{
                value: 20,
                label: "Rock",
                children: [{
                    value: 21,
                    label: "80's"
                },{
                    value: 22,
                    label: "90's"
                }]
            },{
                value: 23,
                label: "Reggae"
            },{
                value: 24,
                label: "Tango"
            }]
        },{
            value: 25,
            label: "Painting"
        }]
    }
];

/*var categoryParents = {};

var _fillDescription = function (categories, currentPath, parent) {
    for (var i = 0; i < categories.length; i++) {
        var category = categories[i];
        //category.parent = parent;
        categoryParents[category.value.toString()] = parent;

        category.desc = currentPath.length === 0 ? "(Root Category)" : currentPath;
        if (category.hasOwnProperty('children')) {
            _fillDescription(category.children, (currentPath.length === 0 ? "" : currentPath + " &#9658; ") + category.label, category);
        }
    }
};

var fillDescription = function (categories) {
    return _fillDescription(categories, "", null);
};


fillDescription(categoriesTree);*/