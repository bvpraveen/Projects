<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />    
<style type="text/css">      
html { height: 100% } 
body { height: 100%; margin: 0; padding: 0 }      

#filter1{ position: absolute;
top: 87px;left: 50px;}

#map_canvas { height:75%; width:100%;position: absolute;
top: 130px;left:0px;} 

#infoWindow {  width: 300px;}

</style>    

<script type="text/javascript"      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB8gW7KScUDWnuLg4SGYcTA1XP5MbWk6LM&sensor=true">    
</script>   
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>



<script>  

var map;

//The below vairables will be used to hold the data displayed and consumed by filter.
var propidArray = [];
var markersArray = [];
var furnishTypeArray = [];
var roomsArray= [];
var propTypeArray = [];
var rentArray = [];
var rentTypeArray = [];
var emailArray = [];



var infoWindow;


function initialize() 
{  
var myLatlng = new google.maps.LatLng(17.48,78.33);      

infoWindow=new google.maps.InfoWindow();

var myOptions = {          center: myLatlng,          
			   zoom: 8,          
			   mapTypeId:google.maps.MapTypeId.ROADMAP        
		};   
		
  if( map == null)
  {
 map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);      
 }
    var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);


        var marker = new google.maps.Marker({
          map: map
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {

          var place = autocomplete.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          var image = new google.maps.MarkerImage(
              place.icon,
              new google.maps.Size(71, 71),
              new google.maps.Point(0, 0),
              new google.maps.Point(17, 34),
              new google.maps.Size(35, 35));
          marker.setIcon(image);
          marker.setPosition(place.geometry.location);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          //infowindow.setContent('<div><strong>' + place.name + '</strong><br>'+address);
          //infowindow.open(map, marker);
        });


//var marker = new google.maps.Marker({      position: myLatlng,      map: map,      title:"Hello World!"  });
//google.maps.event.addListener(map, 'dblclick', function(event) {    addMarker(event.latLng);  });

}
function addMarker1(propid, lat,lang,proptype,propname,owner,rooms,contactno,email,rent,furnishing,amenities,propaddress,description)
{   

	if(map == null)
	{	  
		initialize();
		
	}	

	var latlng= new google.maps.LatLng(lat,lang);  
	var place = rooms+"  "+furnishing+"furnished apartment for rent:"+rent;
	var image = new google.maps.MarkerImage('forrent.jpg');
   var marker = new google.maps.Marker({ position: latlng,  map: map, title: place, icon: image });
   var content="<div id=\"infoWindow\"><html><form name=\"addetails\" action=\"AddPref.php\" method=\"post\" >Property Name:"+propname+"<BR>Owner:"+owner+"<BR>Description:"+description+"<BR>Rooms:"+rooms+"<BR>Furnishing:"+furnishing+"furnished"+"<BR>Amenities:"+amenities+"<BR>Rent:"+rent+"<BR>Address:"+propaddress+"<BR>Contact No."+contactno+"<BR>E-mail:"+email+"<BR><a href=\"javascript:void(0);\" onclick=\"submitMe()\">Add to Preference</a><input type=\"hidden\" name=\"test\" value=\"test\"></input></form></html>" ;  
    //var content="<div id=\"infoWindow\"><html>Property Name:"+propname+"<BR>Owner:"+owner+"<BR>Rooms:"+rooms+"<BR>Furnishing:"+furnishing+"furnished"+"<BR>Amenities:"+amenities+"<BR>Rent:"+rent+"<BR>Address:"+propaddress+"<BR>Contact No."+contactno+"<BR>E-mail:"+email+"<BR><a href='' >Add to Preferences</a></html>" ;  
   // var content="";
   google.maps.event.addListener(marker, 'click', function(){  infoWindow.setContent(content); infoWindow.open(map, marker); });
   propidArray.push(propid);
   markersArray.push(marker);	
  furnishTypeArray.push(furnishing);
  roomsArray.push(rooms);
  propTypeArray.push(proptype);
  rentArray.push(rent);
  emailArray.push(email);
  //rentTypeArray.push();ToDO: to be implemented with sale functionality
	//alert(lat);
}

function submitMe() {
    jQuery(function($) {    
        $.ajax( {           
            url : "AddPref.php",
            type : "POST",
            success : function(data) {
            alert(data);
                alert ("works!"); //or use data string to show something else
                }
            });
        });
    }

function addMarker(location)
{
	var place='Hi';   	
	var marker1 = new google.maps.Marker({    position: location,    map: map, title: place  });  
	markersArray.push(marker1);
} 
google.maps.event.addDomListener(window, 'load', initialize);

function ApplyFilter()
{

	var selectedRooms=parseInt(bedrooms.selectedIndex);
	var selectedFurnish =  furnishing.options[furnishing.selectedIndex].value;
	var selectedPropType= HouseType.options[HouseType.selectedIndex].value;
	var startingPrice="", endingprice="";	
	var currentRooms, currentFurnish,currentPropType,currentRent;
	selectedRooms+=1;
	
   for(var i=0;i<roomsArray.length;i++)
   {
		currentRooms=parseInt(roomsArray[i]);
		currentFurnish=furnishTypeArray[i];
		currentPropType = propTypeArray[i];
		currentRent =parseInt(rentArray[i]);
		var isRentInRange = false;
   	if(fromprice.value != "" && toprice.value != "")
   	{
		  		startingprice=parseInt(fromprice.value);
 		 		endingprice=parseInt(toprice.value);
 		 		if( currentRent >= startingprice && currentRent <= endingprice)
 		 		{
 		 			isRentInRange = true;
 		 		}
   	}
   	else if(fromprice.value != "")
   	{
   		startingprice=parseInt(fromprice.value);
	 		if( currentRent >= startingprice)
 		 		{
 		 			isRentInRange = true;
 		 		}

   	}
   	else if(toprice.value != "")
   	{
 		 		endingprice=parseInt(toprice.value);
		 		if( currentRent <= endingprice)
 		 		{
 		 			isRentInRange = true;
 		 		}

 		 }
 		 else
 		 {
 		 		isRentInRange = true;
 		 }
   	if(currentRooms==selectedRooms && selectedFurnish==currentFurnish && currentPropType == selectedPropType && isRentInRange)
   	{   	
   			markersArray[i].setVisible(true);
   	}
   	else
   	{
   	   markersArray[i].setVisible(false);
   	}

   }
}

String.prototype.startsWith = function(str) 
{return (this.match("^"+str)==str)}

function testAPI() {

    FB.api('/me', function(userInfo) {

        document.getElementById('fbusername').innerHTML ='Welcome '+userInfo.name+'('+userInfo.email+')';

      });
}



function logout()
{
	document.getElementById('fbusername').innerHTML ='';
}

function ResetFilter()
{	
   for(var i=0;i<roomsArray.length;i++)
   		markersArray[i].setVisible(true);
}

function PostedByMe()
{

		var email;
     FB.api('/me', function(userInfo) {    

        email = userInfo.email;
        if(email == null)
        {
        		alert("You must be logged in to see ads posted by you.");
        	
        }
        else
        {
        	   for(var i=0;i<roomsArray.length;i++)
			   {
	   			if(emailArray[i] == email)
	   			{
	   		
	   		   		markersArray[i].setVisible(true);
	   			
	   			}
		   		else
		   		{
	   		   		markersArray[i].setVisible(false);
	   			}	   	
			   }	
		  }

      });    
		
}

function AddtoPreferences(propid)
{

    //alert("Adding propid:"+propid+" to preferences");
    var email;
    FB.api('/me', function(userInfo) {    

        email = userInfo.email;
        if(email == null)
        {
        		alert("You must be logged in to see your preferences.");
        	
        }
        else
        {
        		alert(email);
         	<?php
				$dbc=mysqli_connect('localhost:3306','root','Password~1','irent') or die('Error connect to MYSQL server');
				$query="select * from irent.tbl_preferences";
				$result=mysqli_query($dbc,$query) or die('Error querying  irent.tbl_preferences');
				
				while($row=mysqli_fetch_array($result))
				{
					 $propid = $row['propid'];
				}
				?>

        }
        

      });   
}

function DisplayPreferences()
{

	var email;
	var preferences= [];
     FB.api('/me', function(userInfo) {    

        email = userInfo.email;
        if(email == null)
        {
        		alert("You must be logged in to see your preferences.");
        	
        }
        else
        {
        		alert(email);	
        		<?php
				$dbc=mysqli_connect('localhost:3306','root','Password~1','irent') or die('Error connect to MYSQL server');
				$query="select * from irent.tbl_preferences";
				$result=mysqli_query($dbc,$query) or die('Error querying  irent.tbl_preferences');
				
				while($row=mysqli_fetch_array($result))
				{
					 $propid = $row['propid'];
				}
				?>

        
        }
      });  

        
}

</script>  

</head>  
<body onload="initialize()"> 
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
<a href='javascript:;' onClick='PostedByMe();'  style="color:#FFFFFF;position:absolute;right:250px">Posted by me</a>

<a href="postad.php" style="color:#FFFFFF;position:absolute;right:155px">Post new Ad</a>
<a href='javascript:;'  onClick='DisplayPreferences();'  style="color:#FFFFFF;position:absolute;right:75px">Preferences</a>
<a href="contactus.html" style="color:#FFFFFF;position:absolute;right:5px">Feedback</a>


</div>

<div id="filter1" style="color:#0000FF;">
Search:
<select name="bedrooms" onchange="ApplyFilter()" size="1">
	<option value="1" >1BHK</option>
	<option value="2">2BHK</option>
	<option value="3">3BHK</option>
	<option value="4">4BHK</option>
	<option value="5">5BHK</option>
</select>
<select name="furnishing" onchange="ApplyFilter()" size="1">
	       <option value="semi">Semi-Furnished</option>
		    <option value="full">Fully-Furnished</option>
			 <option value="un">Unfurnished</option>
</select>
<select name="HouseType" onchange="ApplyFilter()" size="1">
	       <option value="Apartment">Apartment</option>
		    <option value="Independent house">Independent house</option>
			 <option value="Villa">Villa</option>
			 <option value="Duplex">Duplex</option>
</select>
for
<select name="purpose" size="1">
			 <option value="sale">Rent</option>
			 <option value="rent">Sale</option>
</select>
&nbsp; in price range
<input type="text" name="fromprice" onchange="ApplyFilter()" size="5">
-
<input type="text" name="toprice" onchange="ApplyFilter()" size="5">
&nbsp; located in <input id="searchTextField" type="text" size="50" ></input>
<a  href='javascript:;' onClick='ResetFilter();'>Reset Filter</a>

</div>

<div id="map_canvas"></div>

<?php
$dbc=mysqli_connect('localhost:3306','root','Password~1','irent') or die('Error connect to MYSQL server');
$query="select * from irent.tbl_property";
$result=mysqli_query($dbc,$query) or die('Error querying  irent.tbl_property');

while($row=mysqli_fetch_array($result))
{

$propid=$row['propertyid'] ;
$lat=$row['lat'];
$lang=$row['lng'];
$proptype="'" . $row['propertytype'] . "'";
$propname="'" . $row['propertyname'] . "'";
$owner="'" . $row['propertyowner'] . "'";
$rooms="'" . $row['rooms'] . "BHK'";
$contactno="'" .$row['contactno']  . "'";;
$email="'" . $row['email']  . "'";
$furnishing="'" . $row['furnished']  . "'";
$propaddress="'" . $row['propertyaddress']  . "'";
$propdescription="'" . $row['propertydescription']  . "'";

//Getting rent and amenities details
$rentquery="select * from irent.tbl_rentalproperty where propertyid=" . "$propid";
$rentresult=mysqli_query($dbc,$rentquery) or die('Error querying  irent.tbl_rentalproperty');
	while($rentrow=mysqli_fetch_array($rentresult))
	{	
			$rent="'" . $rentrow['rent']  . "'";
	}
$amenities = "'";
$amenitiesquery="select * from irent.tbl_amenities where propertyid=" . "$propid";
$amenitiesresult=mysqli_query($dbc,$amenitiesquery) or die('Error querying  irent.tbl_amenities');
	while($amenitiesrow=mysqli_fetch_array($amenitiesresult))
	{	

		if((int)$amenitiesrow['parking4w']==1)
		{
			$amenities=$amenities."Car parking";
		}
		if((int)$amenitiesrow['powerbackup']==1)
		{
			$amenities=$amenities." Powerbackup";
		}
		if((int)$amenitiesrow['playarea']==1)
		{
			$amenities=$amenities." Playarea";
		}
	}
	$amenities = $amenities."'";

	echo 	'<script type="text/javascript">  addMarker1('.$propid.','.$lat.','.$lang.','.$proptype.','.$propname.','.$owner.','.$rooms.','.$contactno.','.$email.','.$rent.','.$furnishing.','.$amenities.','.$propaddress.','.$propdescription.') </script>';

}
?>


</body>
</html>