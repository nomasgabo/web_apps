<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>

<html>
<body>

<table id="table_id" class="display">
    <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 9 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 8 Data 2</td>
        </tr>
        <tr>
            <td>Row 3 Data 1</td>
            <td>Row 7 Data 2</td>
        </tr>
        <tr>
            <td>Row 4 Data 1</td>
            <td>Row 6 Data 2</td>
        </tr>
        <tr>
            <td>Row 5 Data 1</td>
            <td>Row 5 Data 2</td>
        </tr>
        <tr>
            <td>Row 6 Data 1</td>
            <td>Row 4 Data 2</td>
        </tr>
        <tr>
            <td>Row 7 Data 1</td>
            <td>Row 3 Data 2</td>
        </tr>
        <tr>
            <td>Row 8 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
        <tr>
            <td>Row 9 Data 1</td>
            <td>Row 1 Data 2</td>
        </tr>
    </tbody>
</table>

</body>
</html>

<script type="text/javascript">

/*$(document).ready(function() {
    $('#table_id').dataTable( 
    {
        "columnDefs": [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        	}, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        	}],

        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        "searching": false
    	}
    
        
     
    	);
	} 
);*/

$(document).ready(function() {

  
    


  oTable = $('#table_id').dataTable(
  {
        "columnDefs": [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ],
            "bVisible": false
            }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
            }],

        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        "searching": false
        }
    
        
     
        );
 
  oTable.$('td').click( function () {
    var sData = oTable.fnGetData( this );
    alert( 'The cell clicked on had the value of '+sData );
  } );
} );

</script>
