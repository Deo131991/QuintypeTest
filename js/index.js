function authUser(){
	// ajax call 
	$.ajax({

		type:'POST',
		url: 'userHandaler.php',
		data: $(".login-form").serialize()+"&action="+"login",
		success:function(result){
			if (result['massage']!='failed' || result['massage']!='') {
				window.location.href='cabs.php'
			}
		}
	});
}
