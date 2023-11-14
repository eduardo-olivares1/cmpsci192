<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMP SCI 192 | Home</title>
</head>
<body>
    <?php 
    if (!empty($_REQUEST['debug'])) {
        $debug578 = true;
        print "DEBUG turned ON<br>";
        }  
    else {
        $debug578 = false;
         } 
    ?>
    <?php
        $name323 = "Vacay4Sale";
	$addr354 = "789 10th St";
	$city232 = "Seattle WA 98101";
    ?>

    <hr>
    <h2>Lab 6 Assignment</h2>
    <?php
    function getHeader565($companyName, $color)
    {
        $tableStr = <<<MYTABLE
                        <table style='background-color:$color;width:100%'>
                            <tr>
                            <td><h1 style='text-align:center'>$companyName</h1></td>
                            </tr>
                        </table>
                        MYTABLE;

        return $tableStr;
    }

    function getFooter857($color)
    {
        global $name323;
        global $addr354;
        global $city232;
        $tableStr = <<<MYTABLE
                        <table style='background-color:$color'>
                        <tr>
                            <th>Company Name</th>
                            <th>Company Address</th>
                            <th>Company City</th>
                        </tr>
                        <tr>
                            <td>$name323</td>
                            <td>$addr354</td>
                            <td>$city232</td>
                        </tr>
                        </table>
                        MYTABLE;

        return $tableStr;
    }

    echo getHeader565($name323, "green") . "<br>" . getFooter857('orange');
    ?>
   <hr>
   <h2>Lab 5 Assignment</h2>
    <?php
    $myarray726 = null;
    # create array for a Car Dealership
    function  create_array_442()
    {
        $car_array = array();
        $car_array[] = "ID: 12345, Vehicle: 2002 Ford Ranger, $6500.00, Excellent condition, low 68000 miles";
        $car_array[] = "ID: 45678, Vehicle: 1998 Chevy Corvette, $19995.00, Low miles 54000, Great car 4 cruising";
        $car_array[] = "ID: 67890, Vehicle: 2000 Toyota Camry, $9990.00, Mom wants you 2 buy a conservative car";
        $car_array[] = "ID: 89123, Vehicle: 1995 Honda Civic, $4500.00, 140000 miles, but a Honda, it will last";
        return $car_array;
    }
    function display_product_671($array)
    {
        echo "<table style='border:1'>";
        echo "<tr><th>Cars For Sale</th></tr>";
        foreach ($array as $item) {
            print <<<HEREDOC
                        <tr>
                        <td>$item</td>
                        </tr>
                    HEREDOC;
        }
        echo "</table>";
    }

    $myarray726 = create_array_442();

    display_product_671($myarray726);
    ?>
    <hr> 
    <h2>Lab 4 Assignment</h2>
    <?php 
    function display_name_238($parm)
    {
        return "<h1>Name: " . $parm . "</h1>";
    }

    function display_address_363()
    {
        global $addr354;
        return "<b><u>Address: " .  $addr354  . "</u></b>";
    }

    print display_name_238($name323);
    print display_address_363();    
    ?>
    <hr> 
    <h2>Lab 3 Assignment</h2>
    <a href='http://24.144.82.126'>Debug OFF</a>
    <a href='http://24.144.82.126?debug=true'>Debug ON</a> 
    <hr>
    <h2>Lab 2 Assignment</h2>
    <h1><?php print $name323;?></h1>
    <p><?php print $addr354;?></p>
    <b><?php print $city232;?></b>
    <hr />
    <h2>Lab 1 Assignment</h2>
    <p>My name is <?php print "Eduardo Olivares";?></p>
</body>
</html>
