<?php
header("Content-type: application/json; charset=utf-8");

if (isset($_REQUEST['jasonstr'])) {  // get jason object sent as INPUT
  $jasonstr = $_REQUEST['jasonstr'];
  $jsoninput = json_decode($jasonstr);
}
else {
	$jsoninput = new stdClass();
	//EXIT HERE?
}
$phpfile = $jsoninput->scriptname;
if (is_file($phpfile)) {
	ob_start();
	include $phpfile;   //load the students PHP file so we can look at variables and functions
	$string =  ob_get_clean();
}



$jsonobj = new stdClass();
$jsonobj->filename = $_SERVER['SCRIPT_FILENAME'];
$jsonobj->servername = $_SERVER['SERVER_NAME'];
$jsonobj->phpfile = $phpfile;

if (isset($jsoninput->variables)) {
	$jsonobj->variables = array();
	foreach(explode(',',$jsoninput->variables) as $varname) {
	   $varobj['name'] = $varname;
	   $nodollar = substr($varname,1);
	   if (isset(${"$nodollar"})) {
	     $varobj['value'] = ${"$nodollar"};
		 $varobj['type'] = gettype(${"$nodollar"});
		 if ($varobj['type'] == 'boolean') 
			 if ($varobj['value'])
				 $varobj['value']='true';
			 else
				 $varobj['value']='false';
		 if ($varobj['type'] == 'array') 
			$varobj['value']='array';
	   }
	   else {
		 $varobj['value'] = 'not found';
		 $varobj['type'] = 'not found';
	   }
	   $jsonobj->variables[] = $varobj;  // add the variable to the list
	}
}


if (isset($jsoninput->functions)) {
	$jsonobj->functions = array();
	foreach(explode(',',$jsoninput->functions) as $funcname) {
	   $funcobj['name'] = $funcname;
	   try {
	     $func = new ReflectionFunction($funcname);
	     $funcobj['exists'] = 'found';
		 $funcobj['parms'] = $func->getNumberOfRequiredParameters();
	   }
	   catch  (ReflectionException $e) {
		 $funcobj['exists'] = 'not found';
		 $funcobj['parms'] = -1;
	   }
	   $jsonobj->functions[] = $funcobj;  // add the variable to the list
	}
}

/*

jsonobj['fields'] = Submit1.__vardict
jsonobj['vartypes'] = Submit1.__typedict
jsonobj['functions'] = Submit1.__funclist
jsonobj['classlist'] = Submit1.__classlist
jsonobj['objectlist'] = Submit1.__objectlist
jsonobj['localvars'] = localvars
jsonobj['localvartypes'] = Submit1.__loctypedict
*/

if (isset($jsoninput->classes)) {
	$jsonobj->classes = array();
	$jsonobj->methods = array();	
	foreach(explode(',',$jsoninput->classes) as $classname) {
	   $classinfo = array();
	   $classinfo['name'] = $classname;
	   try {
	     $myObjectRef = new ReflectionClass($classname);
	     $classinfo['exists'] = 'found';
	   }
	   catch  (ReflectionException $e) {
		 $classinfo['exists'] = 'not found';
		 $jsonobj->classes[] = $classinfo;  // add the variable to the list
		 continue;  //DO NOT add more of object not found
	   }	
		//print_r($myObjectRef->getProperties());
		foreach ( $myObjectRef->getMethods() as $methobj){
			$obj = new stdClass();
			$obj->name = $methobj->name;
			$obj->classname = $methobj->class;
			$method = new ReflectionMethod($classname, $methobj->name);
			$obj->parms = $method->getNumberOfRequiredParameters();
			$jsonobj->methods[] = $obj;
			//print ("method name is $methobj->name value is $value  class is $methobj->class<br>");
		}
	   $jsonobj->classes[] = $classinfo;  // add the variable to the list
	}  // foreach methods
}	// isset classes
 
if (isset($jsoninput->objects)) {
	$jsonobj->objects = array();
	$jsonobj->properties = array();
	foreach(explode(',',$jsoninput->objects) as $objname) {   //1st explode separates  $object*class,$object*class,$object*class,$object*class
	   $arr = explode('*',$objname);                          //2nd explode separates $object     class
	   $objinfo['name'] = $arr[0];                            //name of OBJECT
	   $nodollar = substr($arr[0],1);                        //name of OBJECT without the $
	   $objinfo['classname'] = $arr[1];                       //name of CLASS
	   try {
	     $myObjectRef = new ReflectionClass($objinfo['classname']);
		 if (isset(${"$nodollar"})) {   // DOES the object exist?
		 $objinfo['exists'] = 'found';
		   $proparray = array();		
			//print_r($myObjectRef->getProperties());
			foreach ( $myObjectRef->getProperties() as $propobj){
				$obj = new stdClass();
				$obj->name = '$'.$propobj->name;  // restore the $ in front
				$obj->classname = $propobj->class;
				$prop = $myObjectRef->getProperty($propobj->name);
				$prop->setAccessible(true);
				$obj->value =  $prop->getValue(${"$nodollar"});
				$obj->type = gettype($prop->getValue(${"$nodollar"}));
				$jsonobj->properties[] = $obj;
				//print ("property name is $obj->name value is $obj->value  type is $obj->type  classname is $obj->classname<br>");
			}
			 
		 }
	     else {
           $objinfo['exists'] = 'not found';
	    }  // end else
	   }
	   catch  (ReflectionException $e) {
		 $objinfo['exists'] = 'not found';
	   }
	   $jsonobj->objects[] = $objinfo;  // add the variable to the list
	}  // foreach properties

}	// isset objects
 
$JSONstr = json_encode($jsonobj);

echo $JSONstr; 

?>
