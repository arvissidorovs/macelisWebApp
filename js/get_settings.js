var a_option = 0;
function load_settings(){	
var url = 'php/get_settings.php';	
	
  $.ajax({url: url, success: function(result){ 
	 o = JSON.parse(result);
	  a_option = 0;
	  if ('a' in o){
	  a_option = o.a;
	  }
	    
	if (is_ao()){
	$('.a_option').removeClass('a_option_hidden');
	}
	else
	{
	$('.a_option').addClass('a_option_hidden');	
	}
	  
  }});

};

function is_ao(){
return a_option==1;
}

function ao_class(){
if (is_ao()){
	return 'a_option';
	}
	else
	{
	return 'a_option a_option_hidden';	
	}
}

load_settings('');



/*		.a_option_hidden {
  		display: none;*/

