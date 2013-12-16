<html>
<head>
<script type="text/javascript">
  function login() {
  
  alert('Inside login');
  
    FB.login(function(response) {
        if (response.authResponse) {
            // connected
            alert('Connected now!');
            testAPI();
        } else {
            // cancelled
            alert('User cancelled');
        }
    });
}
function logout()
{
	alert('Logged out!');
}
function testAPI() {

    alert('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        alert('Good to see you, ' + response.name + '.'+response.username);
    });
    FB.api('/me', function(userInfo) {
        alert(userInfo.name + ': ' + userInfo.email);
      });
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
				

   FB.getLoginStatus(
   function(response) 
   {
//	alert('Reponse');
	
  
 });
    // Additional initialization code such as adding Event Listeners goes here

     //FB.Event.subscribe('auth.login', function(response) { this.page.reload();  alert('Logged in'); alert(response.authResponse.userID); });
     //FB.Event.subscribe('auth.authResponseChange' , function(response) { alert('Response chage'); alert(response.authResponse.userID) });
     FB.Event.subscribe('auth.statusChange', function(response) 
     {  
     		alert(response.status);
     		if(response.status == 'connected')
     		{
     		     testAPI(); 
     		}
     });
     //FB.Event.subscribe('auth.logout', function(response) { logout(); });
     



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

<fb:login-button autologoutlink='true' data-show-faces='true' perms='email,user_birthday,status_update,publish_stream' width='200' data-max-rows='1'></fb:login-button>

</body>
</html>