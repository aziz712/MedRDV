<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Patients</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];


    //echo $userid;
    //echo $username;
    ?>
    <div class="container">
    <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment-sec.php" class="non-style-link-menu"><div><p class="menu-text">Appointments Sec</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="file-patient.php" class="non-style-link-menu"><div><p class="menu-text">Patients File</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="ordonance.php" class="non-style-link-menu"><div><p class="menu-text">ordonance</p></div></a>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <?php       

                    $selecttype="My";
                    $current="My patients Only";
                    if($_POST){

                        if(isset($_POST["search"])){
                            $keyword=$_POST["search12"];
                            
                            $sqlmain= "select * from patient where pemail='$keyword' or pname='$keyword' or pname like '$keyword%' or pname like '%$keyword' or pname like '%$keyword%' ";
                            $selecttype="my";
                        }
                        
                        if(isset($_POST["filter"])){
                            if($_POST["showonly"]=='all'){
                                $sqlmain= "select * from patient";
                                $selecttype="All";
                                $current="All patients";
                            }else{
                                $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid  INNER JOIN doctor ON appointment.docid=doctor.docid  where doctor.docid=$userid;";
                                $selecttype="My";
                                $current="My patients Only";
                            }
                        }
                    }else{
                        $sqlmain= "select * from appointment inner join patient on patient.pid=appointment.pid  INNER JOIN doctor ON appointment.docid=doctor.docid  where doctor.docid=$userid;";
                        $selecttype="My";
                    }



                ?>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%">

                    <a href="patient.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                        
                    </td>
                    <td>
                        
                        <form action="" method="post" class="header-search">

                            <input type="search" name="search12" class="input-text header-searchbar" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp;
                            
                            <?php
                                echo '<datalist id="patient">';
                                $list11 = $database->query($sqlmain);
                               //$list12= $database->query("select * from appointment inner join patient on patient.pid=appointment.pid  INNER JOIN doctor ON appointment.docid=doctor.docid  where doctor.docid=1;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["pname"];
                                    $c=$row00["pemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';
?>
                            
                       
                            <input type="Submit" value="Search" name="search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        
                        </form>
                        
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                        date_default_timezone_set('Africa/Tunis');

                        $date = date('Y-m-d');
                        echo $date;
                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
               

                <tr>
                <td colspan="4">
                    <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Add new patient</div>
                        <a href="?action=add-patient&id=none&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add new </font></button>
                        </a>
                    </div>
                </td>
            </tr>
                
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $selecttype." Patients (".$list11->num_rows.")"; ?></p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
 
                        <form action="" method="post">
                        
                        <td  style="text-align: right;">
                        Show Details About : &nbsp;
                        </td>
                        <td width="30%">
                        <select name="showonly" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                                    <option value="" disabled selected hidden><?php echo $current   ?></option><br/>
                                    <option value="my">My Patients Only</option><br/>
                                    <option value="all">All Patients</option><br/>
                                    

                        </select>
                    </td>
                    <td width="12%">
                        <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>

                    </tr>
                            </table>

                        </center>
                    </td>
                    
                </tr>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
                        <thead>
                        <tr>
                                <th class="table-headin">
                                    
                                
                                Name
                                
                                </th>
                                <th class="table-headin">
                                    
                                
                                    NIC
                                    
                                </th>
                                <th class="table-headin">
                                
                            
                                Telephone
                                
                                </th>
                                <th class="table-headin">
                                    Email
                                </th>
                                <th class="table-headin">
                                    
                                    Date of Birth
                                    
                                </th>
                                <th class="table-headin">
                                    
                                    Events
                                    
                                </tr>
                        </thead>
                        <tbody>
                        
                            <?php

                                
                                $result= $database->query($sqlmain);
                                //echo $sqlmain;
                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="patient.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $pid=$row["pid"];
                                    $name=$row["pname"];
                                    $email=$row["pemail"];
                                    $nic=$row["pnic"];
                                    $dob=$row["pdob"];
                                    $tel=$row["ptel"];
                                    
                                    echo '<tr>
                                        <td> &nbsp;'.
                                        substr($name,0,35)
                                        .'</td>
                                        <td>
                                        '.substr($nic,0,12).'
                                        </td>
                                        <td>
                                            '.substr($tel,0,10).'
                                        </td>
                                        <td>
                                        '.substr($email,0,20).'
                                         </td>
                                        <td>
                                        '.substr($dob,0,10).'
                                        </td>
                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                        <a href="?action=edit&id=' . $pid . '&error=0" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-edit"  style="padding-left: 32px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Edit</font></button></a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="?action=view&id=' . $pid . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 32px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="?action=drop&id=' . $pid . '&name=' . $name . '" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 32px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>
                                        </div>
                                        </td>
                                    </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>
    <?php 
 if ($_GET) {

    $id = $_GET["id"];
    $action = $_GET["action"];
    if ($action == 'drop') {
        $nameget = $_GET["name"];
        echo '
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="patient.php">&times;</a>
                    <div class="content">
                        You want to delete this patient<br>(' . substr($nameget, 0, 40) . ').
                        
                    </div>
                    <div style="display: flex;justify-content: center;">
                    <a href="delete-patient.php?id=' . $id . '" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                    <a href="patient.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                    </div>
                </center>
        </div>
        </div>
        ';
    } elseif ($action == 'view') {
        $sqlmain = "select * from patient where pid='$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $name = $row["pname"];
        $email = $row["pemail"];
        $nic = $row["pnic"];
        $dob = $row["pdob"];
        $tele = $row["ptel"];
        $address = $row["paddress"];
        $region = $row["region"];
        $cnss = $row["cnss"];
        echo '
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                    <a class="close" href="patient.php">&times;</a>
                    <div class="content">

                    </div>
                    <div style="display: flex;justify-content: center;">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                            </td>
                        </tr>
                        <tr>
                            
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Patient ID: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                P-' . $id . '<br><br>
                            </td>
                            
                        </tr>
                        
                        <tr>
                            
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Name: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                ' . $name . '<br><br>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Email" class="form-label">Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                            ' . $email . '<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="nic" class="form-label">NIC: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                            ' . $nic . '<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Tele" class="form-label">Telephone: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                            ' . $tele . '<br><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label">Address: </label>
                                
                            </td>
                        </tr>
                        <tr>
                        <td class="label-td" colspan="2">
                        ' . $address . '<br><br>
                        </td>
                        </tr>
                        <tr>
                            
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Date of Birth: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                ' . $dob . '<br><br>
                            </td>
                            
                        </tr>
                        <tr>
                            
                        <td class="label-td" colspan="2">
                            <label for="pregion" class="form-label">Region </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            ' . $region . '<br><br>
                        </td>
                        
                    </tr>

                    <tr>
                            
                    <td class="label-td" colspan="2">
                        <label for="cnss" class="form-label">Code CNSS </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        ' . $cnss . '<br><br>
                    </td>
                    
                </tr>

                        <tr>
                            <td colspan="2">
                                <a href="patient.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                            
                                
                            </td>
            
                        </tr>
                       

                    </table>
                    </div>
                </center>
                <br><br>
        </div>
        </div>
        ';
    } elseif ($action == 'add-patient') {
        $error_1 = $_GET["error"];
        $errorlist = array(
            '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
            '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
            '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
            '4' => "",
            '0' => '',

        );
        if ($error_1 != '4') {
            echo '
        <div id="popup1" class="overlay">
                <div class="popup">
                <center>
                
                    <a class="close" href="patient.php">&times;</a>
                    <div style="display: flex;justify-content: center;">
                    <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                            <td class="label-td" colspan="2">' .
                $errorlist[$error_1]
                . '</td>
                        </tr>
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Patient.</p><br><br>
                            </td>
                        </tr>
                        
                        <tr>
                            <form action="insertpatient.php" method="POST" class="add-new-form">
                            <td class="label-td" colspan="2">
                                <label for="pname" class="form-label">Name: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="pname" class="input-text" placeholder="Patient Name" required><br>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="pemail" class="form-label">Patient Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="email" name="pemail" class="input-text" placeholder="Email Address" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="pnic" class="form-label">NIC: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="pnic" class="input-text" placeholder="NIC Number" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="ptel" class="form-label">Telephone: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="tel" name="ptel" class="input-text" placeholder="Telephone Number" required><br>
                            </td>
                        </tr>
                       
                        <tr>
                        <td class="label-td" colspan="2">
                            <label for="ppassword" class="form-label">Define Password: </label>
                        </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="password" name="ppassword" class="input-text" placeholder="Define a Password" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="padress" class="form-label">Patient Adress: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="padress" class="input-text" placeholder="Patient Adress" required><br>
                            </td>
                        </tr>

                        <tr>
                        <td class="label-td" colspan="2">
                            <label for="pdob" class="form-label">Date of Birth : </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="date" name="pdob" class="input-text" placeholder="Date of Birth" required><br>
                        </td>
                    </tr>
                        
                    <tr>
                    <td class="label-td" colspan="2">
                        <label for="region" class="form-label">Patient Region : </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="region" class="input-text" placeholder="Patient Region" required><br>
                    </td>
                </tr>

                <tr>
                <td class="label-td" colspan="2">
                    <label for="cnss" class="form-label">Code CNSS : </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="cnss" class="input-text" placeholder="Code CNSS" required><br>
                </td>
            </tr>                        
                
                        <tr>
                            <td colspan="2">
                                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                                <input type="submit" value="Add" class="login-btn btn-primary btn">
                            </td>
            
                        </tr>
                       
                        </form>
                        </tr>
                    </table>
                    </div>
                    </div>
                </center>
                <br><br>
        </div>
        </div>
        ';
        } else {
            echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                        <br><br><br><br>
                            <h2>New Patient Added Successfully!</h2>
                            <a class="close" href="patient.php">&times;</a>
                            <div class="content">
                                
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            
                            <a href="patient.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                            </div>
                            <br><br>
                        </center> 
                </div>
                </div>
    ';
        }
    } elseif ($action == 'edit') {
        $sqlmain = "select * from patient where pid='$id'";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $name = $row["pname"];
        $email = $row["pemail"];
        $nic = $row["pnic"];
        $tele = $row["ptel"];
        $dob = $row["pdob"];
        $address = $row["paddress"];
        $region = $row["region"];
        $cnss = $row["cnss"];

        $error_1 = $_GET["error"];
        $errorlist = array(
            '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
            '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>',
            '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
            '4' => "",
            '0' => '',

        );

        if ($error_1 != '4') {
            echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                        
                            <a class="close" href="patient.php">&times;</a> 
                            <div style="display: flex;justify-content: center;">
                            <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                    <td class="label-td" colspan="2">' .
                $errorlist[$error_1]
                . '</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Patient Details.</p>
                                    Patient ID : ' . $id . ' (Auto Generated)<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <form action="edit-patient.php" method="POST" class="add-new-form">
                                        <label for="Email" class="form-label">Email: </label>
                                        <input type="hidden" value="' . $id . '" name="id00">
                                        <input type="hidden" name="oldemail" value="' . $email . '" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    <input type="email" name="email" class="input-text" placeholder="Email Address" value="' . $email . '" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Name: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="name" class="input-text" placeholder="Secretary Name" value="' . $name . '" required><br>
                                    </td>
                                    
                                </tr>
                                
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nic" class="form-label">NIC: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="nic" class="input-text" placeholder="NIC Number" value="' . $nic . '" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Telephone: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="' . $tele . '" required><br>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="password" class="form-label">Password: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="password" name="password" class="input-text" placeholder="Defind a Password" required><br>
                                    </td>
                                </tr><tr>
                                    <td class="label-td" colspan="2">
                                        <label for="cpassword" class="form-label">Conform Password: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required><br>
                                    </td>
                                </tr>
                                <tr>
                                <td class="label-td" colspan="2">
                                    <label for="dob" class="form-label">Date Of Brith </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="date" name="dob" class="input-text" placeholder="Date Of Brith" value="' . $dob . '" required><br>
                                </td>
                            </tr>

                            <tr>
                            <td class="label-td" colspan="2">
                                <label for="address" class="form-label">Adress: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="address" class="input-text" placeholder="Adress" value="' . $address . '" required><br>
                            </td>
                        </tr>

                        <tr>
                        <td class="label-td" colspan="2">
                            <label for="region" class="form-label">Region: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="text" name="region" class="input-text" placeholder="Region" value="' . $region . '" required><br>
                        </td>
                    </tr>

                    <tr>
                    <td class="label-td" colspan="2">
                        <label for="cnss" class="form-label">Code CNSS: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="cnss" class="input-text" placeholder="Code CNSS" value="' . $cnss . '" required><br>
                    </td>
                </tr>
                    
                                <tr>
                                    <td colspan="2">
                                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    
                                        <input type="submit" value="Save" class="login-btn btn-primary btn">
                                    </td>
                    
                                </tr>
                            
                                </form>
                                </tr>
                            </table>
                            </div>
                            </div>
                        </center>
                        <br><br>
                </div>
                </div>
                ';
        } else {
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br><br><br>
                        <h2>Edit Successfully!</h2>
                        <a class="close" href="patient.php">&times;</a>
                        <div class="content">
                            
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="patient.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

                        </div>
                        <br><br>
                    </center>
            </div>
            </div>
';
        };
    };
};


?>
</div>

</body>
</html>