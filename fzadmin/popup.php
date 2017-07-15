<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
         
        
        <title>Popup</title>
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    
    <body>
<button href="#myModal" id="openBtn" data-toggle="modal" class="btn btn-default">Click</button>

<div class="modal fade" id="myModal">
<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         
        </div>
        <div class="modal-body">
          <h3 class="modal-title">Delivery Agent Report</h3>
        <div class="modal-body">
		  <h5 class="text">Date:</h5>
          <table class="table table-striped" id="tblGrid">
            <thead id="tblHead">
              <tr>
                <th>Restaurant Name</th>
                <th>Billed Amount</th>
                <th>To Pay</th>
				 <th>Delivered Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>Subway</td>
                <td>300</td>
                <td>50</td>
				<td> 250</td>
                 <tr><td>Hideout</td>
                <td>3000</td>
                <td>500</td>
				<td> 270</td>
                 <tr><td>Chinese Corner</td>
                <td>450</td>
                <td>70</td>
				<td> 20</td>
              </tr>
             
            </tbody>
          </table>
          <table class="table table-striped">
<thead><tr><th>Tips</th><th>Petrol</th><th>Food</th><th>Extra</th></tr></thead>
<tbody><tr><td>10</td><td>20</td><td>30</td><td>40</td></tr></tbody>
</table>
        
          <div class="panel panel-default">

            <div class="panel-body">Amount Received Exculding Tips:</div>
 </div>
 <div class="panel panel-default">

            <div class="panel-body">Amount Received Inculding Tips:</div>
 </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
				
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
        
        <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script type='text/javascript' src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>   
     
    </body>
</html>