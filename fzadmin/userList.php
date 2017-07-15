<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Users</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.min.css">
    <link rel="stylesheet" href="">
    <style>
    html, body {
      font-family: 'Roboto', 'Helvetica', sans-serif;
    }
    .fz-logo-image{
  		//margin-top:20px;
  		height:70px;
  		width:70px;
  		border-radius:35px;
  	}
  	.header{
  		margin:25px;
  		margin-left:40px;
  	}
  	.admin-name{
  		padding-top:10px;
  		font-size:18px;
  	}
  	.fz-drawer .mdl-navigation .mdl-navigation__link{
      vertical-align: middle;
  		font-weight:400;
  		color: rgba(255, 255, 255, 0.56);
  		font-size:16px;
      white-space: nowrap;
  	}
  	.material-icons{
      margin-left: 0px;
  		margin-right: 25px;
  		color: rgba(255, 255, 255, 0.56);
  	}
  	.fz-_drawer .mdl-navigation .mdl-navigation__link:hover {
  		color: #37474F;
  	}
    .fz-header {
      overflow: visible;
      background-color: white;
    }
    .fz-header .material-icons {
      color: #767777 !important;
    }
    .fz-header .mdl-layout__drawer-button {
      background: transparent;
      color: #767777;
    }
    .fz-header .mdl-navigation__link {
      color: #757575;
      font-weight: 700;
      font-size: 14px;
    }
    .fz-header .-logo-image {
      height: 60px;
      width: 240px;
      position: absolute;
      bottom: 16px;
    }
    .fz-mobile-title {
      display: block !important;
      position: absolute;
      left: calc(50% - 70px);
      top: 12px;
      transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .fz-title {
      display: block !important;
    }
    .fz-content{
      background-color: #f3f3f3;
      overflow: scroll;
    }
    .fz-footer {
      background-color: #fafafa;
      overflow: hidden;
      position: relative;
      bottom: 0;
      width: inherit;
      right: 0;
    }
    .mdl-data-table{
      margin:15px;
      padding-right: 10px;
    }
    .mdl-data-table th{
      font-size: 14px;
    }
    .add{
	position:relative;
	margin:20px;
    }
    #addfield{
    	display:none;
    }
    @media (max-width: 900px) {
      .fz-navigation-container {
        display: none;
      }

    </style>
  </head>
  <body>
  <?
    include "../conf/config.php";
    include "check_login.php";    
  ?>
  	<?

	function value($box){
		if($box!="1")
			return 0;
		return 1;
	}
	$output="";
	if(isset($_POST['submit'])){
		$checkSQL=mysql_query("SELECT username FROM adminUsers WHERE username='".$_POST['username']."'");
		if(mysql_num_rows($checkSQL)>0)
			$output="Username exists!";
		else if(strlen($_POST['username']) <4 || strlen($_POST['password'])<6)
			$output="Username or Password is small";
		else{ 
			$str = "INSERT INTO adminUsers VALUES('".$_POST['username']."','". md5($_POST['password'])."','".strtoupper($_POST['city'])."',".$_POST['delivery_type'].",". value($_POST['dashboard']).", ".value($_POST['orders']).", ".value($_POST['coupons']).", ".value($_POST['reports']).", ".value($_POST['creports']).", ".value($_POST['service']).",". value($_POST['offers']).",". value($_POST['settings']).",". value($_POST['users']).",". value($_POST['customers']).",". value($_POST['feedback']).")";
			$result =mysql_query($str);
			$output="New User Added!";
		}
	}
	
	?>
	<?
		$SQL="SELECT * from adminUsers;";
		$result=mysql_query($SQL);
	?>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <div class="fz-header mdl-layout__header mdl-layout__header--waterfall">
        <div class="mdl-layout__header-row">
          <span class="fz-title mdl-layout-title">
            <img src="http://www.beta.foodzoned.com/img/logo-3.png">
          </span>
        </div>
      </div>
      <? include "a1.php"; ?>
      <div class="fz-content mdl-layout__content">
        <a name="top"></a>
	    <table class="fz-table mdl-data-table mdl-js-data-table mdl-shadow--2dp">
	      <thead>
	        <tr>
	          <th class="mdl-data-table__cell--non-numeric">Username</th>
	          <th class="mdl-data-table__cell--non-numeric">Password</th>
	          <th class="mdl-data-table__cell--non-numeric">City</th>
	          <th class="mdl-data-table__cell--non-numeric">Delivery Type</th>
	          <th>Dashboard</th>
	          <th>Orders</th>
	          <th>Company Reports</th>
	          <th>Service Reports</th>
	          <th>Service Provider</th>
	          <th>Offers</th>
	          <th>Coupons</th>
	          <th>Settings</th>
	          <th>Users</th>
	          <th>Customers</th>
	          <th>Feedbacks</th>
	          <th></th>
	        </tr>
	      </thead>
	      <tbody>
	        <? while($row=mysql_fetch_array($result)){ ?>
	        <tr>
	          <td class="mdl-data-table__cell--non-numeric">
	            <?=$row[ 'username'];?>
	          </td>
	          <td class="mdl-data-table__cell--non-numeric">
	            <?=$row[ 'password'];?>
	          </td>
	          <td class="mdl-data-table__cell--non-numeric">
	            <?=$row[ 'City'];?>
	          </td>
	          <td class="mdl-data-table__cell--non-numeric">
	            <? if ($row[ 'Delivery_Type']==1) echo 'FZ Delivery'; else if($row[ 'Delivery_Type']==2) echo 'Self Delivery'; else echo 'All';?>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-dashboard'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-dashboard'?>" class="mdl-checkbox__input" 
		       				<?if ($row['Dashboard'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-orders'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-orders'?>" class="mdl-checkbox__input" 
		       				<?if ($row['Orders'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-creports'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-creports'?>" class="mdl-checkbox__input" 
		       				<?if ($row['Company Reports'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-sreports'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-sreports'?>" class="mdl-checkbox__input"
		       				<?if ($row['Service Reports'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-sprovider'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-sprovider'?>" class="mdl-checkbox__input" 
		       				<?if ($row['Service Provider'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-offer'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-offer'?>" class="mdl-checkbox__input"
		       				<?if ($row['Offers'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-coupon'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-coupon'?>" class="mdl-checkbox__input"
		       				<?if ($row['Coupons'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-setting'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-setting'?>" class="mdl-checkbox__input"
		       				<?if ($row['Settings'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-user'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-user'?>" class="mdl-checkbox__input"
		       				<?if ($row['Users'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-cust'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-cust'?>" class="mdl-checkbox__input"
		       				<?if ($row['Customers'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	          <td>
	            <span class="mdl-list__item-secondary-action">
		      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="<?=$row['username'] . '-fback'?>">
		       				<input type="checkbox" id="<?=$row['username'] . '-fback'?>" class="mdl-checkbox__input"
		       				<?if ($row['Feedbacks'])
		       					echo 'checked'; ?> />
		     			</label>
		    		</span>
	          </td>
	
	        </tr>
	        <? } ?>
	        <tr id="addfield">
	          <form id="myform" name="myform" method="post" action="userList.php">
	            <td class="mdl-data-table__cell--non-numeric">
	              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label field">
	                <input class="mdl-textfield__input" type="text" id="username" name="username">
	                <label class="mdl-textfield__label label" for="username">Username</label>
	              </div>
	            </td>
	            <td class="mdl-data-table__cell--non-numeric">
	              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label field">
	                <input class="mdl-textfield__input" type="text" id="password" name="password">
	                <label class="mdl-textfield__label label" for="password">Password</label>
	              </div>
	            </td>
	            <td class="mdl-data-table__cell--non-numeric">
	              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label field">
	                <input class="mdl-textfield__input" type="text" id="city" name="city">
	                <label class="mdl-textfield__label label" for="city">City</label>
	              </div>
	            </td>
	            <td class="mdl-data-table__cell--non-numeric">
	              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label field">
	                <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="delivery_type" name="delivery_type">
	                <label class="mdl-textfield__label label" for="delivery_type">Delivery Type</label>
	                <span class="mdl-textfield__error">Input is not a number!</span>
	              </div>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="dashboard">
			       				<input type="checkbox" id="dashboard" name="dashboard" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="orders">
			       				<input type="checkbox" id="orders" name="orders" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="creports">
			       				<input type="checkbox" id="creports" name="creports" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="reports">
			       				<input type="checkbox" id="reports" name="reports" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="service">
			       				<input type="checkbox" id="service" name="service" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="offers">
			       				<input type="checkbox" id="offers" name="offers" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="coupons">
			       				<input type="checkbox" id="coupons" name="coupons" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="settings">
			       				<input type="checkbox" id="settings" name="settings" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="users">
			       				<input type="checkbox" id="users" name="users" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="customers">
			       				<input type="checkbox" id="customers" name="customers" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <span class="mdl-list__item-secondary-action">
			      			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="feedback">
			       				<input type="checkbox" id="feedback" name="feedback" class="mdl-checkbox__input">
			     			</label>
			    		</span>
	            </td>
	            <td>
	              <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored button" name="submit">submit</button>
	          </form>
	        </tr>
	      </tbody>
	    </table>
	    <div>
	      <? echo $output ?>
	    </div>
	    <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored mdl-js-ripple-effect add" onclick="addf()">
	      <i class="material-icons">add</i>
	    </button>
	  </div>
      </div>
  <script>
	function addf(){
		document.getElementById("addfield").style.display = "table-row";
	}
  </script>
  <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
  </body>
</html>