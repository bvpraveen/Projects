<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />    

<style type="text/css">      
html { height: 100% } 
body { height: 100%; margin: 0; padding: 0 }      
.labelDetail{
width:120px;
}
.contactDiv{
padding-bottom: 12px;
}


#adform { position: absolute;
top:100px;left:10px} 

#map_canvas { height:1200%; width:150%;position: absolute;left:0px; top:50px }

#contact_form { height:500%; width:100%;position: absolute;left:0px; top:360px }

#buttons { position: absolute;left:400px;bottom:0px;} 

</style>    



<script type="text/javascript"      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB8gW7KScUDWnuLg4SGYcTA1XP5MbWk6LM&sensor=true">    
</script>   

<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>


<script type="text/javascript">  

var map;
var geocoder;

var markersArray = [];
var placeMarker, searchMarker;

function initialize() 
{ 
	var myLatlng = new google.maps.LatLng(17.48,78.33);  
	geocoder= new google.maps.Geocoder();    

	var myOptions = {          center: myLatlng,          
			   zoom: 14,          
			   mapTypeId:google.maps.MapTypeId.ROADMAP        
		};    
	if(map== null)
	{
	 map = new google.maps.Map(document.getElementById("map_canvas1"),myOptions);      
	 }
    var input = document.getElementById('autoCompleteGmap');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
          map: map
          });
   google.maps.event.addListener(autocomplete, 'place_changed', function() {
   	infowindow.close();
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

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>'+address);
          //infowindow.open(map, marker);
        });	
		    
	// map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);      
	//var marker = new google.maps.Marker({      position: myLatlng,      map: map,      title:"Hello World!"  });
	google.maps.event.addListener(map, 'dblclick', function(event) {    addMarker(event.latLng);  });	

}

function addMarker(location) { 

//var place=window.prompt("Enter the place name:");
var place=document.getElementById("autoCompleteGmap").value;  
var image = new google.maps.MarkerImage('forrent.jpg');
if(placeMarker != null)//set the existing marker to null
placeMarker.setMap(null);
placeMarker = new google.maps.Marker({    position: location,    map: map, title: place, icon:image  }); 
rentdetails.lat.value=location.lat();
rentdetails.lang.value=location.lng();
debugger;
markersArray.push(placeMarker); 
  } 
 
 function codeAddress() 
 {    

 	var address = document.getElementById("autoCompleteGmap").value;    
 	var image = new google.maps.MarkerImage('forrent.jpg');
 	geocoder.geocode( { 'address': address}, function(results, status) {      
 	if (status == google.maps.GeocoderStatus.OK) {
 	map.setCenter(results[0].geometry.location); 
 	if(searchMarker != null)
 	{
 		searchMarker.setMap(null);
 	}
 	searchMarker = new google.maps.Marker({            
 	map: map,            
 	position: results[0].geometry.location,
 	//icon: image	        
 	});      
 	} else {       
 	 alert("Unable to locate due to error:" + status);      }    
 	 }
 	 );
 	 
}
 google.maps.event.addDomListener(window, 'load', initialize);
 
 
 function testAPI() {

    FB.api('/me', function(userInfo) {


        document.getElementById('fbusername').innerHTML ='Welcome '+userInfo.name+'('+userInfo.email+')';
        document.getElementById('email').value = userInfo.email;

      });
}

function logout()
{
	document.getElementById('fbusername').innerHTML ='';
  document.getElementById('email').value = '';
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
<div style="display:inline">
<div style="float:right;width:60%;">
<div class="input-group" style="">
  <span class="input-group-addon"style="display:inline;padding-top:14px;padding-bottom:7px;">Located in</span>
  <input type="text" id="autoCompleteGmap" class="form-control" style="width:670px;margin-bottom: 9px;margin-top: 1px;height: 39px" placeholder="Enter Your Place Here...">
</div>
<div id="map_canvas1" style="background-color:#FFFFFF;height:400px;margin-top:-8px"></div>

</div>
<div id="property_details" class="panel panel-primary" style="width:40%;height:1000px"> 
<div class="panel-heading">
    Property Details
  </div>
   <div class="panel-body">  
   <div class="contactDiv">
  <label class="labelDetail"><b>Property Name</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Property Name">
  </div>    
   <div><label class="labelDetail">Bedrooms</label>
   <select class="selectpicker" data-width="100px">
    <option>1</option>
    <option>2</option>
    <option>3</option>
	<option>4</option>
	<option>5</option>
  </select></div>
  <div><label class="labelDetail">Furnish</label>
  <select class="selectpicker" data-width="160px">
    <option>Fully-Furnished</option>
    <option>Semi-Furnished</option>
    <option>UnFurnished</option>
  </select>
  </div>
  <div>  <label class="labelDetail">Type</label>
    <select class="selectpicker" data-width="170px">
    <option>Apartment</option>
    <option>Independent House</option>
    <option>Villa</option>
	<option>Duplex</option>
  </select>  
  <label>For</label>
  <select class="selectpicker" data-width="100px">
    <option>Rent</option>
    <option>Sale</option>
  </select> 
  </div>  
  <div class="contactDiv">
  <label class="labelDetail" ><b>Rent(incl.All)</b></label>
  <input type="text" class="form-control" style="display:inline;width:150px" placeholder="Enter Rent Fare">
  </div>
  <div class="contactDiv">
  <label class="labelDetail"><b>Description</b></label>
  <textarea class="form-control" rows="2" style="display:inline;width:250px"></textarea>
  </div>
   <hr>
  <div class="panel-heading"style="margin-top: 0px;padding-left: 0px;padding-top: 0px;padding-bottom: 0px;border-bottom-width: 5px;">
      <label style="color:rgba(136, 133, 133, 0.68);"><h3 style="margin-bottom: 0px;margin-top: 0px;">Amenities</h3>
	  </label>
  </div>
  <div>
   
   <div>
      <input type="checkbox"> Car Parking</input>
	  <input type="checkbox" style="margin-left: 30px;"> Gym</input>
	  <input type="checkbox" style="margin-left: 100px;"> Garden</input>
   </div>
   <div>
	  <input type="checkbox"> Children Park</input>
	  <input type="checkbox" style="margin-left: 19px;"> Power Generator</input>
	  <input type="checkbox" style="margin-left: 20px;"> Lift</input>
	</div>
	<div>
	  <input type="checkbox"> Security Guard</input>
	  <input type="checkbox" style="margin-left: 11px;"> Swimming pool</input>
	  <input type="checkbox" style="margin-left: 35px;"> Sports Room</input>
	</div>
  
  <hr>
  <div class="panel-heading"style="margin-top: 0px;padding-left: 0px;padding-top: 0px;padding-bottom: 0px;border-bottom-width: 5px;">
	<label style="color:rgba(136, 133, 133, 0.68);"><h3 style="margin-top: 0px;margin-bottom:0px;">Property Address</h3></label></div>

  <div class="contactDiv">
  <label class="labelDetail"><b>Address</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Address">
  </div>
  <div class="contactDiv">
  <label class="labelDetail"><b>City</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter City">
  </div>
  <div class="contactDiv">
  <label class="labelDetail"><b>State</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Address">
  </div>
  <div class="contactDiv">
  <label class="labelDetail"><b>Country</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Country Name">
  </div>
  <div class="contactDiv">
  <label class="labelDetail"><b>Pincode</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Pincode">
  </div>
   <hr>
  <div class="panel-heading"style="margin-top: 0px;padding-left: 0px;padding-top: 0px;padding-bottom: 0px;border-bottom-width: 5px;"><label style="color:rgba(136, 133, 133, 0.68);"><h3 style="margin-bottom:0px;margin-top: 0px;">Contact Details</h3></label></div>
  
  <div class="contactDiv">
  <label class="labelDetail"><b>Name</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Name">
  </div>
  <div class="contactDiv">
  <label class="labelDetail"><b>Phone.No</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Valid Phone.no">
  </div>
  <div class="contactDiv">
  <label class="labelDetail"><b>E-mail</b></label>
  <input type="text" class="form-control" style="display:inline;width:250px" placeholder="Enter Valid Email">
  </div>
  <div >
  <button type="button" class="btn btn-default">Save</button>
  <button type="button" class="btn btn-default">Cancel</button>
  </div>
   </div>
   
   </div>
</div>

</div>
  <hr>
      <footer>
        <p>Copyright &copy; 2013 iRent All rights reserved</p>
      </footer>

<script src="bootstrap/jQuery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/bootstrap-select.js"></script>
	<!-- Bootstrap core CSS -->
     <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	 <link href="bootstrap/bootstrap-select.css" rel="stylesheet">
	 <script type="text/javascript">       
            $('.selectpicker').selectpicker({
                'selectedText': 'Relish'
            });
    </script>	
</body>
</html>