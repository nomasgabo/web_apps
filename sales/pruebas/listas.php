<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Connect lists</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  #sortable1, #sortable2 { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; }
  #sortable1 li, #sortable2 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
  </style>
  <script>
  
 $(function(){
    $( "#sortable1" ).sortable({
        connectWith: ".connectedSortable",
        update: myFunc
    }).disableSelection();

    $( "#sortable2" ).sortable({
        connectWith: ".connectedSortable",  // deactivate:myFunc
    }).disableSelection();

    function myFunc(event, ui){
        var b = $("#sortable1 li"); // array of sorted elems
        for (var i = 0, a = ""; i < b.length; i++)
        {
            var j=i+1; // an increasing num.
            a = a + j + ") " + $(b[i]).html() + '\n ' //putting together the items in order
        }
        alert(a)                 
    }
});

  </script>
</head>
<body>
 
<ul data-header="heading" id="sortable1" class="connectedSortable">
  <li class="ui-state-default" value="1" onclick="alert($(this).parent().attr('id'))">Item 1</li>
  <li class="ui-state-default">Item 2</li>
  <li class="ui-state-default">Item 3</li>
  <li class="ui-state-default">Item 4</li>
  <li class="ui-state-default">Item 5</li>
</ul>
 
<ul id="sortable2" class="connectedSortable">
  <li class="ui-state-highlight">Item 1</li>
  <li class="ui-state-highlight">Item 2</li>
  <li class="ui-state-highlight">Item 3</li>
  <li class="ui-state-highlight">Item 4</li>
  <li class="ui-state-highlight">Item 5</li>
</ul>

</body>
</html>