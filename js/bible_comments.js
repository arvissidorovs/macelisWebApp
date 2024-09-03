
function show_section(section_id){	
load_settings('');	
$('.main_section_selector').hide();	
$('#'+section_id).show();	
}

var bible_coments_loaded = false;

function show_section_comments(){
show_section('section_comments');	
//load_bible_comments(0);
if (!bible_coments_loaded){
	bible_coments_loaded = true;
	load_comment_books(current_tr);		
	}
}

function show_section_comments_editor(){
show_section('section_comments_editor');	
}

function show_section_bible(){
show_section('section_bible');	
}

function show_section_bible_results(){
show_section('section_bible_results');	
}

var dictionary_loaded = false;

function show_section_dictionary(){
show_section('section_dictionary');	
	if (!dictionary_loaded){
	dictionary_loaded = true;
	load_dictionary(0);	
	}
}

function load_all_on_init(){
if (!bible_coments_loaded){
	bible_coments_loaded = true;
	load_comment_books(current_tr);		
	}
if (!dictionary_loaded){
	dictionary_loaded = true;
	load_dictionary(0);	
	}
}


function open_edit_comment(id){
//show_section('section_comments_editor');	
//$('#iframe_comments_editor').attr('src', '/editor/?id='+id);	
window.open('/editor/?id='+id);		
}


function open_edit_dictionary(id){
//show_section('section_comments_editor');	
//$('#iframe_comments_editor').attr('src', '/editor/?id='+id);	
window.open('/editor/dictionary.php?id='+id);	
}


function load_bible_comments(b){
var ofset = 0;
$("#div_comments").html('Notiek ielāde...');	
$("#div_comments").html('');	
	
	
var url = '/php/load_bible_comments.php?ofset='+ofset+'&b='+b;		
	
  $.ajax({url: url, success: function(result){
	 o = JSON.parse(result); 
	 //$("#div_comments").html('');	 
	if (o.rez == 1){
		
		var id = o.comemnts[0].id;
		var title = o.comemnts[0].title;
		var html = o.comemnts[0].html;
		  
	  /**/
	 /*var comemnts = o.comemnts;
	 var i=0;
		while (i < comemnts.length) {
		  	var coment_id = comemnts[i].id;	
    	  	var coment_title = comemnts[i].title;
		  	var coment_html = comemnts[i].html;
		  	var html = '<div id="div_comment_'+coment_id+'"'+
							'<div>'+
								'<a href="#" style="float: right; color:#D3D3D3;" onclick="open_edit_comment('+coment_id+')">Labot</a>'+
							'</div>'+
							'<a type="button">'+
								'<div class="comment-verse vertical-hr" style="overflow: hidden;" onclick="toggle_comment_html('+coment_id+')">'+
								coment_title+ //coment_html+
								'</div>'+
							'</a>'+
							'<div style="font-family: Linguistics Pro;  display:none;" class="mb-4-5" id="div_comment_html'+coment_id+'" >'+
							coment_html+
							'</div>'+
						'</div>';
	 		$("#div_comments").append(html);
			i++;
		}
	}*/
		
	var comemnts = o.comemnts;
	 var i=0;
		while (i < comemnts.length) {
		  	var coment_id = comemnts[i].id;	
    	  	var coment_title = comemnts[i].title;
		  	var coment_html = comemnts[i].html;
		  	var html = '<div class="vertical-hr accordion accordion-flush accordion-bg">'+
            '<div class="accordion-item">'+
              '<div class="accordion-header">'+
                '<div class="row">'+
                  '<div class="col-10">'+
                    '<div type="button" class="comment-verse" onclick="showDescription('+coment_id+')">'+coment_title+'</div>'+
                  '</div>'+
                  '<div class="col-2 text-end '+ao_class()+'">'+
                    '<a type="button" style="color: #D3D3D3;" onclick="open_edit_comment('+coment_id+')">Labot</a>'+
                  '</div>'+
                '</div>'+
                '<div class="dictionary-description" id="description_'+coment_id+'">'+coment_html+'</div>'+
              '</div>'+
            '</div>'+
          '</div>';

		
	 		$("#div_comments").append(html);
			i++;
		}
	}
	  /**/
	  
	  /*
	  <div id="div_comments">
						<div id="div_comment_1">
							<div>
							Virsraksts
							</div>
							<div>
							Teksts
							</div>
							</div>
					</div>
	  */
	  
	 
  }});

};	


function toggle_comment_html(coment_id){
$('#div_comment_html'+coment_id).toggle();	
}
					


function load_dictionary(ofset){

$("#div_dictionary").html('Notiek ielāde...');	
	
var url = '/php/load_dictionary.php?ofset='+ofset;		
	
  $.ajax({url: url, success: function(result){
	  o = JSON.parse(result); 
	 $("#div_dictionary").html('');	 
	if (o.rez == 1){
		
		var id = o.dictionary[0].id;
		var word = o.dictionary[0].word;
		var html = o.dictionary[0].html;
		  
	  /**/
	  var list = o.dictionary;
	 var i=0;
		while (i < list.length) {
		  	var dictionary_id = list[i].id;	
    	  	var dictionary_word = list[i].word;
		  	var dictionary_html = list[i].html;
			
			
			/*var html = '<div class="vertical-hr">'+
							'<div>'+
							'<a href="#" style="float: right; color:#D3D3D3;" onclick="open_edit_dictionary('+dictionary_id+')">Labot</a>'+
							'</div>'+
					     '<div class="dictionary-word">'+
						dictionary_word+
						'</div>'+
						'<div class="dictionary-description">'+
						dictionary_html+
						'</div>'+
					'</div>';*/
			
			var html = '<div class="vertical-hr accordion accordion-flush" style="--bs-accordion-bg: rgba(255, 255, 255, 1);">'+
            '<div class="accordion-item">'+
              '<div class="accordion-header">'+
                '<div class="row">'+
                  '<div class="col-10">'+
       '<div type="button" class="dictionary-word" onclick="showDescription(\'dictionary_'+dictionary_id+'\')">'+dictionary_word+'</div>'+
                  '</div>'+
                  '<div class="col-2 text-end '+ao_class()+'">'+
                    '<a type="button" style="color: #D3D3D3;" onclick="open_edit_dictionary('+dictionary_id+')">Labot</a>'+
                  '</div>'+
                '</div>'+
                '<div class="dictionary-description" id="description_dictionary_'+dictionary_id+'">'+dictionary_html+'</div>'+
              '</div>'+
            '</div>'+
          '</div>';

		
	 		$("#div_dictionary").append(html);
			i++;
		}
	}	
	  /**/
	  	 
  }});

};

function showDescription(tag_id) {
    // Get the description element
    var descriptionElement = $('#description_' + tag_id);

    // Toggle the visibility of the description
    descriptionElement.toggle();
}


function load_comment_books(tr){	
$("#div_comments").html('Lūdzu izvēlies nodaļu!');		
var url = 'php/load_comment_books.php?tr=lv';	
	
  $.ajax({url: url, success: function(result){ 
	 o = JSON.parse(result);
	 coment_names = o;  
	 html = '<li><a class="dropdown-item" href="#" onclick="changeDropdownText(\'Jaunākie\'); load_bible_comments(0);">Jaunākie</a></li>'; 
	  if (o.length>0) {
	  	var i = 0;
		  while (i < o.length) {
		   //var b = o[i].i;
		   //var s = o[i].s;
			  var id = o[i].i;
			  var a = o[i].a;
			  var count = o[i].count;
			  var cc_html = '';
			  if (count>0) { cc_html = '('+count+')';}
			  
			 var c_html = '';
		  	 var c_max = o[i].c;
		  	 //var ic = 1;
			  
			  
			  if (count>0){
			 	html = html +
				//	'<span id="accordionChapter" onclick="load_bible_comments('+id+')">'+a+cc_html+'</span>,&nbsp;&nbsp;'; 
				  '<li><a class="dropdown-item" href="#" onclick="changeDropdownText(\''+a+cc_html+'\'); load_bible_comments('+id+');">'+a+cc_html+'</a></li>';
			  }
	 		i++;
		  }
	  } 
	  
	 // $("#comment_book_names_list").html(book_names_html);
	 $("#comment_book_names").html(html);
	  //comment_book_names
//	 onclickOTbutton(); 
//	loadInitURL();
//changeDropdownText('Jaunākie');
	  load_bible_comments(0);	  
  }});

};

