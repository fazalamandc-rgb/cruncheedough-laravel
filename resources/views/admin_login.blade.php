<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">			
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

    <script type="text/javascript">
        function validate_form() {
            var username = document.forms["frm"]["textUser"].value;
            var txtid = document.forms["frm"]["txtid"].value;

            if (username == "" || txtid == "") {
                alert("Enter User name and Email/Cell No");
                return false;
            }
        }
    </script>

    <title>CRUNCHEEDOUGH </title>
    <style>
        /* Your existing CSS styles here */
    </style>
</head>
<body bgcolor="#3399CC">
<br><br>
<form name="frm" action="{{ url('procloadm') }}" method="post" onsubmit="return validate_form();">
   
    @csrf
    <div align="center"></div>
    <div align="center">
        <font color="green" size="7" face="Arial, Helvetica, sans-serif">
            CRUNCHEEDOUGH ADMIN PANEL
            
          </font>
        <table width="546" bgcolor="#006699" align="center" border="1">
            <tr> 
                <td height="55" colspan="2">
                    <div align="center">
                        <font color="green" size="3" face="Arial, Helvetica, sans-serif">
                            Enter User Name &amp; Email/Cell No to continue order
                        </font>
                    </div>
                </td>
            </tr>
            <tr> 
                <td height="52"><font color="gray">User Name:</font></td>
                <td><input type="text" name="textUser"></td>
            </tr>
            <tr> 
                <td height="61"><font color="gray">password:</font></td>
                <td><input type="password" name="txtPwd"></td>

              
            </tr>
            <tr>
                <td>
                    
              
                    <a href="{{ route('mp') }}">Back Login</a>
                </td>
                
                <td><input type="submit" name="Submit" value="Continue"></td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>
