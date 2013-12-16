<html>
<head>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />    

<style type="text/css">      
html { height: 100% } 
body { height: 100%; margin: 0; padding: 0 }      

</style>
<script>
function testAPI() {

    FB.api('/me', function(userInfo) {


        document.getElementById('fbusername').innerHTML ='Welcome '+userInfo.name+'('+userInfo.email+')';

      });
}

function logout()
{
	document.getElementById('fbusername').innerHTML ='';
}


</script>  
</head>
<body>
<div id="fb-root"></div>
<script>

  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '316843605051461',                        // App ID from the app dashboard
      status     : true,                                 // Check Facebook Login status
      xfbml      : true                                  // Look for social plugins on the page
    });
    
     FB.Event.subscribe('auth.statusChange', function(response) 
     {  
     		if(response.status == 'connected')
     		{
     		     testAPI(); 
     		}
			else
     		{
     		     logout();
     		}

     });
     
};
</script>
<script>
  // Load the SDK asynchronously
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all.js";
     fjs.parentNode.insertBefore(js, fjs);

   }(document, 'script', 'facebook-jssdk'));   
</script>

				

   

<div id="heading1" style="color:#FFFFFF;background-color:#0000FF;height:11%">
&nbsp;&nbsp;&nbsp;<font size="+3">iRent</font>&nbsp;
<font>Map your rental needs</font>

<BR>
<label id="fbusername"></label>
<fb:login-button autologoutlink='true' data-show-faces='false' perms='email,user_birthday,status_update,publish_stream' width='200' data-max-rows='1'  style="position:absolute;right:400px"></fb:login-button>
<a href="home.php" style="color:#FFFFFF;position:absolute;right:350px">Home</a>
<a href="postad.php" style="color:#FFFFFF;position:absolute;right:250px">Posted by me</a>
<a href="postad.php" style="color:#FFFFFF;position:absolute;right:155px">Post new Ad</a>
<a href="" style="color:#FFFFFF;position:absolute;right:75px">Contact us</a>
<a href="" style="color:#FFFFFF;position:absolute;right:5px">Feedback</a>


</div>



<?php

/*$price= $_POST['price'];
$bedrooms= $_POST['bedrooms'];
$locality= $_POST['address'];
$lat= $_POST['lat'];
$lang= $_POST['lang'];*/



//$query="insert into rentdetails values('Venkata','$locality','$locality','$price','$lat','$lang')";

//Get the number of entries
$dbc=mysqli_connect('localhost:3306','root','Password~1','irent') or die('Error connect to MYSQL server');
//	$query="select * from tbl_ad";


$bedrooms = $_POST['bedrooms'];
$furnishing = $_POST['furnishing'];
$housetype = $_POST['HouseType'];
$purpose = $_POST['purpose'];
$lat = $_POST['lat'];
$lang = $_POST['lang'];
$address = $_POST['address'];
$carparking = isset($_POST['CarParking'])? 'true' : 'false' ;
$powerbackup =(isset($_POST['PowerBackup'])? 'true' : 'false');
$playarea = isset($_POST['Playarea'])? 'true' : 'false' ;
$rent = $_POST['rent'];
$owner = $_POST['owner'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$propname = $_POST['propertyname'];
$propaddress = $_POST['propertyaddress'];
$propdescription=$_POST['description'];
$errormsg = 'Error whilie trying to post the ad to the DB. Please verify the data entered and try again. ';


//Add property details
//propertyname text, propertyaddress text, propertytype text,propertyowner text, rooms int, size float, floor int, flooring text,contactno text, email text, facing text,lat float,lng float,areaname text, furnished text
$propertyinsertquery="insert into irent.tbl_property(propertyname,propertyaddress,propertytype,propertyowner,rooms,size,floor,flooring,contactno,email,facing,lat,lng,areaname,furnished,propertydescription) 
values('$propname','$propaddress','$housetype','$owner',$bedrooms,1230,2,'Tiles','$phone','$email','East',$lat,$lang,'$address','$furnishing','$propdescription')";


$result=mysqli_query($dbc,$propertyinsertquery) or die($errormsg);

//Query property id
$propertyid = mysqli_insert_id($dbc);

//Add rent details

$rentinsertquery="insert into irent.tbl_rentalproperty(propertyid, rent, maintainence,advances,availabledate)
values($propertyid,$rent,0,3,null)";

$result=mysqli_query($dbc,$rentinsertquery) or die($errormsg);

//Add sale details

//Add amenities

$amenitiesquery= "insert into irent.tbl_amenities(propertyid,parking4w,powerbackup,playarea)
values($propertyid,$carparking,$powerbackup,$playarea)";

$result=mysqli_query($dbc,$amenitiesquery) or die($errormsg);

echo $propdescription;
echo '<BR><BR>Your ad has been successfully posted.';

?>
</body>
</html>