console.log('productGroups.js loadimng');


$(document).ready(function () {
    $('#jstree_demo_div').jstree(
        {
            'core': {
                'data': data(),
            },
        }
    );

    $('#jstree_demo_div')
        // listen for event
        .on('changed.jstree', function (e, data) {
            console.log(data.node);

        })
        // create the instance
        .jstree();
});

function data(){
    return [
        { "id": "ajson1", "parent": "#", "text": "Simple root node" },
        { "id": "ajson2", "parent": "#", "text": "Root node 2" },
        { "id": "ajson3", "parent": "ajson2", "text": "Child 1" },
        { "id": "ajson4", "parent": "ajson2", "text": "Child 2" },
        { "id": "ajson5", "parent": "ajson4", "text": "Child 2" },
    ]
}
