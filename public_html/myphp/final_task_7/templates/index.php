<html>
<head>
    <meta charset='utf8'/>
    <title>%TITLE%</title>
    <link rel='stylesheet' href='css/bootstrap.min.css'/>
    <link rel='stylesheet' href='css/style.css'/>
    <script src="js/jquery.js" ></script>
    <script src="js/script.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
    <div><h2>Contact Form</h2></div>
    <div class="%SUCCESS%"   id="mes">
        <strong>%ERRORS%</strong>
    </div>
    <div class="wrap_form">
    <form method="post" role="form" action="index.php">
     <div class="form-group">
        <label class='control-label' for="fullname" >FullName:</label>
        <input type="text" name="data[fullname]" class="form-control" id="fullname" placeholder="Enter fullname" value="%FULLNAME%" />
        <p class='error' id='fullname_error'></p>
    </div>
    <div class="form-group">
        <label class='control-label' for="subject" >Subject:</label>
        <select class = "form-control" name="data[subject]" id="subject">
            <option value="null" %DEFAULT%>Please select</option>
            <option value="order" %ORDER%>Specification by order</option>
            <option value="question" %QUESTION%>Question about the product</option>
            <option value="opt" %OPT%>Wholesale purchase</option>
        </select>
        <p class='error' id='subject_error'></p>
    </div>
    <div class="form-group">
        <label class='control-label' for="email" >E-mail:</label>
        <input type="text" name="data[emailTo]" class="form-control" id="email" placeholder="Enter email" value="%EMAILTO%"/>
        <p class='error' id='e_mail_error'></p>
    </div>
    <div class="form-group">
         <label class='control-label' for="message" >Message:</label>
        <textarea name="data[message]" id="message" class="form-control"  placeholder="Enter message">%MESSAGE%</textarea>
        <p class='error' id='message_error'></p>
    </div>
    <p class='error' id='error'></p>
    <button type="submit" class="btn btn-success" >Send mail</button>
</form>
</div>
</body>
</html>

