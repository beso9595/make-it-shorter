/*
	30.12.2015
*/


function getLink(data){
	$("#message").text(data);
}

$(document).ready(function(){
	$("input[name='shorter']").bind("click", function(){
		$.post((document.location.origin + "/lib/script.php"), {link: $("input[name='link']").val()}, getLink);
	});
});

//

function createLink(data){
	$("#message").text(data);
}

$(document).ready(function(){
	$("input[name='create']").bind("click", function(){
		$.post((document.location.origin + "/lib/script.php"), {c_link: $("input[name='c_link']").val(), code: $("input[name='code']").val()}, createLink);
		
	});
});

//

function installConfig(data){
	$("#ins_message").text(data);
}

$(document).ready(function(){
	$("input[name='install']").bind("click", function(){
		$.post((document.location.origin + "/lib/script.php"), {
			address: $("input[name='address']").val(),
			sitename: $("input[name='sitename']").val(),
			title: $("input[name='title']").val(),
			hostname: $("input[name='hostname']").val(),
			username: $("input[name='username']").val(),
			password: $("input[name='password']").val(),
			database: $("input[name='database']").val(),
			prefix: $("input[name='prefix']").val(),
			sec_word: $("input[name='sec_word']").val(),
			mail: $("input[name='mail']").val(),
			language: $("select[name='language']").val()
		}, installConfig);
		
	});
});

//

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function changeLang(id){
	var index = id.substring(5, 7);		//lang_en => en
	createCookie("lang", index);
}

//

$(document).ready(function(){
	$("#navigator li").bind("click", function(){
		$("#message").text("");
	});
});