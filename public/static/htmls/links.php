<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../css/admin.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>links</title>
</head>

<body>
    
<?php 
// 管理员
if($_COOKIE['role_id'] == 1){
?>

<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseOne">
                <span class="glyphicon glyphicon-lock"></span>
                Privilege Management
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <ul>
                    <li><a class="links" href="../../role/Role/role.html" target="content">Check & Modify Privilege</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseTwo">
                <span class="glyphicon glyphicon-briefcase"></span>
                Comany Management
            </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                <li id="link1"><a  class="links" href="../../Departments/departments/departments.html" target="content">Check Departments</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapsefive">
                <span class="glyphicon glyphicon-briefcase"></span>
                Comany Management
            </a>
            </h4>
        </div>
        <div id="collapsefive" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                <li id="link1"><a  class="links" href="../../products/products/products.html" target="content">Check Products</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseThree">
                <span class="glyphicon glyphicon-user"></span>
                Customers Management
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                    <li><a class="links" href="../../customer/Information/information" target="content">Check Customers</a></li>
                    <li><a class="links" href="../../afterSale/Index/index" target="content">Check Aftersalelists</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseFour">
                <span class="glyphicon glyphicon-list-alt"></span>
                Orderlists Management
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                    <li><a class="links" href="../../customOrder/Information/information" target="content">Check Orderlists</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php }?>

<!-- 经理 -->
<?php 
if($_COOKIE['role_id'] == 2){
?>
<div class="panel-group" id="accordion">
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseTwo">
                <span class="glyphicon glyphicon-briefcase"></span>
                Comany Management
            </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                    <?php
                    $a = $_COOKIE['department_id'];
                    echo"<li id='link1'><a  class='links' href='../../Department/department/department.html?department_id=$a' target='content'>Check Department & Products</a></li>";
                    echo"<li><a class='links' href='../../staff/staff/staff.html?department_id=$a' target='content'>Check Staff</a></li>";
                     ?>
                     <li><a class="links" href="../../customOrder/managerAnalysis/managerAnalysis" target="content">Check track record</a></li>
                     <li><a class="links" href="../../chart/Chart/showcharta.html" target="content">Check Chart</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseThree">
                <span class="glyphicon glyphicon-user"></span>
                Customers Management
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                    <li><a class="links" href="../../customOrder/index" target="content">Check Customers & Orderlists</a></li>
                    <li><a class="links" href="../../afterSale/Index/index" target="content">Check Aftersalelists</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php }?>

<!-- 我是销售 -->
<?php 
if($_COOKIE['role_id'] == 3){
?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseTwo">
                <span class="glyphicon glyphicon-briefcase"></span>
                Department Management
            </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                <?php
                    $a = $_COOKIE['department_id'];
                    echo"<li id='link1'><a  class='links' href='../../Department/department/department.html?department_id=$a' target='content'>Check Department & Products</a></li>";
                ?>
                
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseThree">
                <span class="glyphicon glyphicon-user"></span>
                Customers Management
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                    <li><a class="links" href="../../customOrder/index" target="content">Check Customers & Orderlists</a></li>
                    <li><a class="links" href="../../customOrder/managerAnalysis/managerAnalysis" target="content">Check track record</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php }?>

<!-- 售后 -->
<?php 
if($_COOKIE['role_id'] == 4){
?>
<div class="panel-group" id="accordion">
<div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseThree">
                <span class="glyphicon glyphicon-list-alt"></span>
                Aftersale List
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                    <?php
                    $a = $_COOKIE['employee_id'];
                    echo"<li><a class='links' href='../../afterSale/Index/index/employee_id/$a' target='content'>Check & Modify Aftersalelists</a></li>";
                     ?>
                    <li><a class="links" href="../../afterSale/AfterSale/show" target="content">Add Aftersalelists</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" 
                href="#collapseFour">
                <span class="glyphicon glyphicon-list-alt"></span>
                Feedback List
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                <?php
                    $a = $_COOKIE['employee_id'];
                    echo"<li><a class='links' href='../../feedback/Index/index/employee_id/$a' target='content'>Check Feedbacklists</a></li>";
                     ?>
                    <li><a class="links" href="../../feedback/Feedback/show" target="content">Add Feedbacklists</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php }?>
    
</body>
</html>