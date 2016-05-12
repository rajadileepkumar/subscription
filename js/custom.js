$('#submit_button').on('click',function(e){
	if($('#userName').val() == ''){
		$('#userName').css('border-color','red');
		$('.error-message').css('display','block');
		return false;
	}
	else{
		$('userName').css('border-color','')
	}

	if($('#password').val() == ''){
		$('#password').css('border-color','red');
		$('.error-message').css('display','block');
		return false;
	}

	else{
		$('#password').css('border-color','');
	}

});