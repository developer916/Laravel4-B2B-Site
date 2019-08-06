function onSignOut(){
		$.ajax({
	        url: "./async-logOut.php",
	        dataType : "json",
	        type : "POST",
	        data : {  },
	        success : function(data){
	            if(data.result == "success"){
	                window.location.href = "index.php";
	            }
	        }
	    });	
				
}