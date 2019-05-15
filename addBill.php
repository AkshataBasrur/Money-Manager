<?php
require_once("config.php");
require_once("header.php");

    function get_friends()
    {
        $str='<div class="container">
		<div class="row">
			 <div class="col-lg-12">
		   <div class="button-group">
			  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></button>
	  <ul class="dropdown-menu">';
        $x=fetchAllUsers();
        /*print_r($x);*/
        while(list($k,$v)=each($x))
        {
            $str.='<br/> <input type="checkbox" value="'. $v["UserName"]. '"name="friend[]"/>'. $v["UserName"];
		}
		$str.='</ul>
		</div>
	  </div>
		</div>
	  </div>';
        return $str;
    }
 if(isset($_POST['Send']))
 {
	 $friends=$_POST['friend'];
	 $mon=$_POST['mon'];
	 /*echo $mon;
	 print_r($friends);
     foreach($friends as $friend)
     {
         echo $friend;
	 }*/
	 funcAddBill($friends,$mon);
 }
?>
<html>
<head>
<title>Add Bill</title>
<style>
body
{
  font-family: Open sans, Helvetica;
  background: #111;
  color: white;
  font-size: 16px;
}

h1
{
  font-weight: lighter;
}

small
{
  color: firebrick;
}

div.checkbox_select
{
  width: 200px;
}

.checkbox_select_anchor
{
  display: block;
  background: firebrick;
  color: white;
  cursor: pointer;
  padding: 10px 5px 5px;
  position: relative;
}

.checkbox_select_anchor:after
{
  width: 0; 
	height: 0; 
	border-left: 10px solid transparent;
	border-right: 10px solid transparent;
	border-top: 10px solid darkred;
  content: "";
  position: absolute;
  right: 10px;
  top: 15px;
}

.expanded .checkbox_select_anchor:after
{
	border-top: 0;
	border-bottom: 10px solid firebrick;
}


.checkbox_select_anchor:hover
{
  background: #FF3030 !important;
}

.expanded .checkbox_select_anchor
{
    background: #7C1818;
}

div.checkbox_select .select_input
{
    width: 100%;
    cursor: pointer;
}

.checkbox_select_dropdown
{
    display: none;
    background: whitesmoke;
}

.checkbox_select_dropdown.show
{
    display: block;
}

.checkbox_select_dropdown ul
{
    max-height: 150px;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 0;
  margin: 0;
      border: 1px solid #999;
  border-top: 0;
  border-bottom: 0;
}
.checkbox_select_dropdown ul li
{
    list-style: none;
    position: relative;
    color: #666;
}
.checkbox_select_dropdown ul li label
{
  position: relative;
      padding: 10px 5px 5px 40px;
     display: block;
  cursor: pointer;
}
.checkbox_select_dropdown ul li label:hover
{
  background: #cbcbcb;
  color: white;
}
.checkbox_select_dropdown ul li input:checked + label
{
  background: #bbb;
  color: white;
  text-shadow: 0px 1px 1px rgba(150, 150, 150, 1);
}
.checkbox_select_dropdown ul li input
{
  position: absolute;
  left:0;
  z-index:1;
  display: inline-block;
  height: 100%;
  width: 30px;
}
.checkbox_select_search
{
    width: 200px;
    padding: 10px 5px 5px;
    border: 1px solid #999;
      border-top: 0;
    -webkit-box-sizing: border-box;
	  -moz-box-sizing: border-box;
	  box-sizing: border-box;
}

.checkbox_select_submit
{
    background: #00A600;
    color: white;
    padding: 10px 5px 5px;
    border: 0;
    width: 100%;
    font-size: 14px;
    cursor: pointer;
}

.hide
{
    display: none;
}


</style>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<?php echo get_friends();?>
<br>
Enter Amount: <input type="text" name="mon"><br>
<input type="submit" value="Send" name="Send">
</form>
</body>
</html>