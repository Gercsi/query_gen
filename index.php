<?php
    function Generate(){
        echo "The Generate function is called.";
    }  
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>

  <link rel="stylesheet" href="css/bootstrap.css">

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item">
        <a href="Reset.php" class="btn btn-warning">Reset Your Password</a>
      </li>
      <li class="nav-item">
        <a href="Logout.php" class="btn btn-danger">Sign Out of Your Account</a>
      </li>
      
      </ul>
  </div>
</nav>
<div class="card">
    <div class="row">
        <div class="col-md-6">
          <textarea rows="20" name="input_area" id="input_area" class="form-control" placeholder="Input"></textarea>
        </div>
          
        <div class="col-md-6">
          <textarea rows="20" name="output_area" id="output_area" class="form-control" placeholder="Output"></textarea>
        </div>
    </div>
  </div>
    <button class="btn btn-secondary" id="generate">Generate</button>
    <button class="btn btn-success" id="base_code">Base Code</button>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">How to use</button>
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p>help</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
      $(document).ready(function () { 
            $("#generate").click(function () { 
                var txt = $("#input_area").val();
                var string_parts = txt.split("\n");
                var i;
                var from = '';
                var select = '';
                var where = '';
                var order_by= '';
                var join = '';
                for(i = 0; i < string_parts.length ; i++)
                {
                  
                  if(string_parts[i].includes("Table_session()")){
                    seged = string_parts[i].split(':').pop().split(';').join('');
                    from = "FROM " + seged + "\n";
                  }
                  
                  if(string_parts[i].includes("Select_session():;")){select = "SELECT * \n";}
                  else if(string_parts[i].includes("Select_session()")){
                    seged = string_parts[i].split(':').pop().split(';').join('');
                    select = "SELECT " + seged + "\n";
                  }
                  
                  if(string_parts[i].includes("Where_session()")){
                    seged = string_parts[i].split(':').pop().split(';').join('');
                    seged = seged.replace(',', " AND ");
                    seged = seged.replace('|', " OR ");
                    where = "WHERE " + seged + "\n";
                  }

                  if(string_parts[i].includes("Order_section()")){
                    seged = string_parts[i].split(":").pop().split(";").join('');
                    order_by = "ORDER BY " + seged + "\n";
                  }

                  if(string_parts[i].includes("Join_session()")){
                    
                    seged = string_parts[i].split(":").pop().split(";").join('');
                    const indexOfFirst = seged.indexOf('_');
                    from = seged.substring(seged.indexOf('[') + 1, indexOfFirst);
                    to = seged.substring(seged.indexOf('_',(indexOfFirst+1)) + 1, seged.indexOf('_',(indexOfFirst+2)));
                    join_type = seged.substring(seged.indexOf('(') + 1, seged.indexOf(')'));
                    var from_table = from.substring(0,from.indexOf('.'));
                    var to_table = to.substring(0,to.indexOf('.'));
                    if(join_type.includes("--")){
                      from = "FROM " + from_table +" INNER JOIN " + to_table + "\nON " + from + "=" + to + "\n"; 
                    }
                    if(join_type.includes("++")){
                      from = "FROM " + from_table +" FULL OUTER JOIN " + to_table + "\nON " + from + "=" + to + "\n"; 
                    }
                    if(join_type.includes("+-")){
                      from = "FROM " + from_table +" LEFT JOIN " + to_table + "\nON " + from + "=" + to + "\n"; 
                    }
                    if(join_type.includes("-+")){
                      from = "FROM " + from_table +" RIGHT JOIN " + to_table + "\nON " + from + "=" + to + "\n"; 
                    }

                  }

                }
                var result = select + from + where + order_by + join + "\n";
                document.getElementById('output_area').value = document.getElementById('output_area').value + result;
            }); 
        }); 
    </script>
    <script>
      $(document).ready(function () { 
            $("#base_code").click(function () { 
                var txt = "Table_session():teszt;\nSelect_session():proba,proba1;\nWhere_session():proba>5;\nOrder_section():teszt;\nJoin_session():[teszt.proba__teszt1.proba2_(--)];";
                document.getElementById('input_area').value = txt;
                 
            }); 
        }); 
    </script>   
</body>
</html>