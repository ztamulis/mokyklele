
var iconPickerOptions = {searchText: "", labelHeader: "{0}/{1}"};

var sortableListOptions = {
    placeholderCss: {'background-color': "#cccccc"}
};
var editor = new MenuEditor('myEditor',
    {
        listOptions: sortableListOptions,
        iconPicker: iconPickerOptions,
        maxLevel: 2
    });

var arrayjson = [{"href":"http://home.com","icon":"fas fa-home","text":"Home", "target": "_top", "title": "My Home"},{"icon":"fas fa-chart-bar","text":"Opcion2"},{"icon":"fas fa-bell","text":"Opcion3"},{"icon":"fas fa-crop","text":"Opcion4"},{"icon":"fas fa-flask","text":"Opcion5"},{"icon":"fas fa-map-marker","text":"Opcion6"},{"icon":"fas fa-search","text":"Opcion7","children":[{"icon":"fas fa-plug","text":"Opcion7-1","children":[{"icon":"fas fa-filter","text":"Opcion7-1-1"}]}]}];
editor.setData(arrayjson);

editor.setForm($('#frmEdit'));
editor.setUpdateButton($('#btnUpdate'));

$("#btnUpdate").click(function(){
    editor.update();
});

$('#btnAdd').click(function(){
    editor.add();
});


