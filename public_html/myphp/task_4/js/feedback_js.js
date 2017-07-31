var author_check = false,email_check = false,message_check = false;

//имя отправителя не менее 4 символов
function keyPressAuthor(elem){
var erlog = document.getElementById("err_log");
	if(elem.value.length>=4){
		erlog.style.display="none";
		log_check=true;
	}
	else{
		erlog.style.display="block";
		log_check=false;
	}
}


function check_email() {
    var $email = $("#email").val();
    var re = /^[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?(\.)[A-Za-z0-9]{2,3}$/;
    if (re.test($email) !== true) {
        $('#e_mail_error').html('неверный формат');
    }
    else {
        $('#e_mail_error').html('');
        return true;
    }
}

function check_author() {
    var re = /^[\-_A-Za-z0-9]+$/;
    var $author = $("#author").val();
    
    if (re.test($author) !== true)
    {
        $('#author_error').html('использованы недопустимые символы');
    }
    else if ($author.length < 4)
    {
        $('#author_error').html('слишком короткий');
    }
    else {
        $('#author_error').html('');
        return true;
    }
}

/*
function send(){
    
    if ( check_author()  && check_email() ) {
        var mes = $('#message').val();
        var email = $('#email').val();
        var author = $('#author').val();
    
        if (author == "" || email == "" || mes == "") {
            $('#error').html('не все поля заполнены');
        }
        else {
            $('#error').html('');
 
            $('#error').html('');
            $.ajax({
                url: "index.php?page=registration/insertClient",
                data: "login=" + login + "&password=" + password1 + "&e_mail=" + e_mail + "&phone=" + phone + "&name=" + name + "&surname=" + surname + "&address=" + address,
                type: 'POST',
                success: function(answer) {
                    // alert(answer)
                    if (answer > 0) {
                        params = {height: 500, width: 500}
                        $('#popup').append($('<div id="reg_ans">Спасибо за регистрацию</div>').css({position: "absolute",
                            left: $(window).width() / 2 - params.width / 2,
                            bottom: $(window).height() / 2 - params.height / 2,
                            background: 'lightblue',
                            border: '1px solid BLUE'
                        }))
                        setTimeout(function() {
                            $('#popup').remove()
                        }, 3000);
                        $("#")
                    }
                    else {
                        params = {height: 500, width: 500}
                        $('#popup').append($('<div id="reg_ans">Ошибка регистрации.</div>').css({position: "absolute",
                            left: $(window).width() / 2 - params.width / 2,
                            bottom: $(window).height() / 2 - params.height / 2,
                            background: 'lightblue',
                            border: '1px solid BLUE'
                        }))
                    }
                }
            }
        }
    }
}
*/