<?php
require_once("config.php");
require_once("header.php");

$thisuser = $loggedInUser->username;
$takeList = fetchMyTakeList();
//deleteTakeExpense($takeList['uniqueid']);

?>
<head>
<title>give list </title>
<style>
table{ 
  border-spacing: 1; 
  border-collapse: collapse; 
  background:white;
  border-radius:6px;
  overflow:hidden;
  max-width:800px; 
  width:100%;
  margin:0 auto;
  position:relative;
  
  *{ position:relative }
  
  td,th{ padding-left:8px;}

  thead tr{ 
    height:60px;
    background:#FFED86;
    font-size:16px;
  }
  
  tbody tr{ height:48px; border-bottom:1px solid #E3F1D5 ;
    &:last-child  { border:0; }
  }
  
 	td,th{ text-align:left;
		&.l{ text-align:center }
		&.c{ text-align:center }
		&.r{ text-align:center }
	}
}
body{ 
  background:black; 
  font:400 14px 'Calibri','Arial';
  padding:20px;
}
$gl-ms: "screen and (max-width: 23.5em)"; // up to 360px
$gl-xs: "screen and (max-width: 35.5em)"; // up to 568px
$gl-sm: "screen and (max-width: 48em)";   // max 768px
$gl-md: "screen and (max-width: 64em)";   // max 1024px
$gl-lg: "screen and (max-width: 80em)";   // max 1280px
@media #{$gl-xs}{
  
  table{ display:block;
	  > *,tr,td,th{ display:block }
    
    thead{ display:none }
    tbody tr{ height:auto; padding:8px 0;
      td{ padding-left:45%; margin-bottom:12px;
        &:last-child{ margin-bottom:0 }
        &:before{ 
          position:absolute;
          font-weight:700;
          width:40%;
          left:10px;
          top:0
        }
        &:nth-child(1):before { content:"UserID";}
        &:nth-child(2):before { content:"UserName";}
        &:nth-child(3):before { content:"FirstName";}
        &:nth-child(4):before { content:"LastName";}
        &:nth-child(5):before { content:"Zelle Email";} 
        &:nth-child(6):before { content:"Money";}
      }        
    }
  }
}  

blockquote {
  color:white;
  text-align:center;
}

  input[type=button] {
  background-color: #81ea00;
  color: black;
  padding: 8px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s;
  
}
input[type=button]:hover {
  background-color: #45a049;
  border-radius: 20px;
}
     
</style>
</head>
<body>
<blockquote><h1> List of friends</h1></blockquote>
<table>
<thead style="height:60px;text-align:center;
    background:#FFED86;
    font-size:16px;"> <tr><th> UserID</th><th> UserName </th> <th> FirstName</th> <th>LastName</th><th> Zelle Email </th> <th>Money</th></tr></thead><tbody>
<?php while( list($k,$v) =each($takeList))
{
    echo "<tr><td>". $v["UserID"] ."</td>". "<td>". $v["UserName"] ."</td>". "<td>". $v["FirstName"] ."</td>". "<td>". $v["LastName"] ."</td>"."<td>". $v["Email"] ."</td>". "<td>". $v["money"] ."</td><td><input type='button' value='Settle payment' onclick='".deleteTakeExpense($v["uniqueid"])."'></td></tr>"; 
}
?>
</tbody>

</table>
</body>
</html>