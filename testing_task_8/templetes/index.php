<!DOCCTYPE html>
<html>
    <head>
        <title>Task 1</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>
    </head>
    <body>
        <div class="container">
  
            <form class="form-inline" method="post" action="index.php" class="search_form">
                <div class="form-group">
                  <input type="text" name="search"  class="form-control" placeholder="search world"/>
                  <button class="btn btn-success">Search</button>
                </div>
            </form>
            
            <br>
            <div class="result_search"> 
                <pre><?=$result?></pre>
            </div>
            
        </div>
    </body>
</html>


