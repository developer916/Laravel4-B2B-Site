function onCancelProfile(){
	window.location.href="./overview.php";
}

function onSaveProfilePassword(){
	var currentPassword = $("#currentPassword").val();
	if(currentPassword == "") {$("#currentPasswordEmptyError").show(); return;}
	var newPassword = $("#newPassword").val();
	var confirmNewPassword = $("#confirmNewPassword").val();
	if(newPassword == "") { $("#newPasswordInsertError").show(); return;}
	if(newPassword != confirmNewPassword){
		$("#confrimPasswordError").show(); 
		return;
	}
	
	$.ajax({
		 url: "./async-saveProfilePassword.php",
			cache : false,
			dataType : "json",
			type : "POST",
			data : {currentPassword:currentPassword,newPassword:newPassword},
			success : function(data){
				
				if(data.result == "success"){
					$("#profilePasswordChangedSuccessfully").show();
					window.location.reload();
				}
				else if(data.result == "failed"){
					$("#currentPasswordInsertError").show();
				}
			}
	});	
}
