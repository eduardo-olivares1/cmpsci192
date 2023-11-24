<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMP SCI 192 | Page 2</title>
</head>

<body>
    <?php
    function isLocalhost($whitelist = ['127.0.0.1', '::1'])
    {
        return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
    }

    class Company541
    {

        public $co_name3 = 'House_R_Us';
        private $co_addr3 = '123 Main St';
        private $co_city3 = 'Boston MA 02101';
        protected $whichpage = "Home";
        protected $sqldb5 = null;

        function getDatabase457()
        {
            $db_host = getenv('DB_HOST');
            $db_user = getenv('DB_USER');
            $db_pass = getenv('DB_PASS');
            $db_database = "companydb";
            try {
                $this->sqldb5 = new mysqli($db_host, $db_user, $db_pass, $db_database);
                print "<b>Database " . $db_database . " connect and select complete</b>";
            } catch (Exception $e) {
                $this->sqldb5 = null;
                print "<b>Unable to connect to database</b>";
            }
        }

        function closeDatabase785()
        {
            if ($this->sqldb5 != null) {
                $this->sqldb5->close();
                print "<b>Database closed</b>";
            }
        }

        function getHeader565($color)
        {
            $tableStr = <<<MYTABLE
                            <table style='background-color:$color;width:100%'>
                                <tr>
                                <td><h1 style='text-align:center'>$this->co_name3</h1></td>
                                </tr>
                            </table>
                            MYTABLE;

            return $tableStr;
        }

        function getFooter857($color)
        {

            $tableStr = <<<MYTABLE
                            <table style='background-color:$color'>
                            <tr>
                                <th>Company Name</th>
                                <th>Company Address</th>
                                <th>Company City</th>
                            </tr>
                            <tr>
                                <td><b>$this->co_name3</b></td>
                                <td><b>$this->co_addr3</b></td>
                                <td><b>$this->co_city3</b></td>
                            </tr>
                            </table>
                            MYTABLE;

            return $tableStr;
        }
    }

    class Child521 extends Company541
    {
        private $main_url;
        private $main_email;
        private $navbar_array = array();

        public function __construct()
        {
            $this->co_name3 = "Eduardo Olivares Cars";
            if (isLocalhost()) {
                $this->main_url = "http://localhost";
            } else {
                $this->main_url = "http://24.144.82.126";
            }
            $this->main_email = "eolivares2@my.canyons.edu";
        }

        function  main_info508()
        {
            // create a local variable which will contain html
            $html_response = "";
            // assign/append to the local variable a <strong> tag with 'Email Address: ' followed by what is in the variable $this->main_email and a </strong> closing tag
            $html_response = "<strong> Email Address: " . $this->main_email . "</strong>";
            // append to the local variable an <a href=...> tag linking to the variable $this->main_url and with the message 'Click HERE for Web Page #1' before the </a>
            // return the local variable 
            $html_response .= "<a href='" . $this->main_url . "'>Click HERE for Web Page #1</a>";
            return $html_response;
        }

        # create array for a Car/house/travel Nav Bar
        function  create_navbar_array()
        {
            $fullurl = $this->main_url . "/page2.php";   // get the main url address of this web page
            $this->navbar_array = array(
                "Home" => "$fullurl?whichpage=Home", "Sales" => "$fullurl?whichpage=Sales",
                "Support" => "$fullurl?whichpage=Support", "Contacts" => "$fullurl?whichpage=Contacts"
            );
        }

        function getNavBar494()
        {
            $this->create_navbar_array();
            $html_response = "<table>";
            foreach ($this->navbar_array as $key => $value) {
                $html_response .= "<td><a href='$value'>$key</a></td>";
            }
            $html_response .= "</table>";
            return $html_response;
        }

        function setWhichPage()
        {
            if (isset($_GET['whichpage'])) {
                $this->whichpage = $_GET['whichpage'];
            } else {
                $this->whichpage = "Home";
            }
        }

        function getMain450()
        {
            $this->setWhichPage();
            $html_response = "<h1>The " . $this->whichpage . " Page</h1>";
            $page = ucfirst($this->whichpage);
            if ($page == "Home") {
                $html_response .= $this->displaySpecials313();
            } else if ($page == "Sales") {
                $html_response .= $this->getSqlProduct476();
            } else if ($page == "Support") {
                // TODO: call method(s) to create Support page table (NOT DONE YET)
            } else if ($page == "Contacts") {
                // TODO: call method(s) to create Contacts page table (NOT DONE YET)
            } else {
                $html_response .= "Error Unknown web page requested ($page)";
            }

            return $html_response;
        }

        function displaySpecials313()
        {
            $html_response = "<div align='center'><h3>Weekly Specials</h3><table border='1' width='50%'><tbody>";
            $fileContents = file_get_contents('car.txt');
            $rows = explode("\n", $fileContents);

            foreach ($rows as $row) {
                $columns = explode(",", $row);
                $html_response .= "<tr>";
                foreach ($columns as $column) {
                    $html_response .= "<td>$column</td>";
                }
                $html_response .= "</tr>";
            }

            $html_response .= "</table></div>";
            return $html_response;
        }

        function getSqlProduct476()
        {
            $sql = "SELECT * FROM CarProduct";
            try {
                $result = $this->sqldb5->query($sql);
            } catch (Exception $e) {
                return $html_response = "<div align='center'><h3>ERROR: " . $e->getMessage() . "</h3></div>";
            }
            $html_response = "<div align='center'><h3>Sales</h3><table border='1' width='50%'><tbody>";
            while ($row = $result->fetch_assoc()) {
                $html_response .= "<tr>";
                $html_response .= "<td>" . $row['productID'] . "</td>";
                $html_response .= "<td>" . $row['productName'] . "</td>";
                $html_response .= "<td>" . $row['price'] . "</td>";
                $html_response .= "<td>" . $row['productDescription'] . "</td>";
                $html_response .= "</tr>";
            }
            $html_response .= "</table></div>";
            return $html_response;
        }
    }

    $object508 = new Child521();
    $object508->getDatabase457();
    echo $object508->getHeader565("green") . $object508->getNavBar494() . $object508->getMain450() .  $object508->main_info508() . $object508->getFooter857('orange');
    $object508->closeDatabase785();
    ?>
</body>

</html>