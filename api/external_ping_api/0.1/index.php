<?php
/*
Copyright (c) CS-Digital UG (hatungsbeschränkt) https://cs-digital-ug.de/ 

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/
echo "<!-- Copyright (c) CS-Digital UG (hatungsbeschränkt) https://cs-digital-ug.de/  -->";


/*
Identifier: CKrQsyvQRNJIMjZxb8JkkYoQTkJHqMI4jBcONhX1Yvsn9ZmgrFqRt9iQYNNMHYOZ6AHQhv7qFQUmBflxEe3DNMExHuVNDWFNboaIGLaaR391m8b4NApkI97ty4D8RaMG8WugCFGmeSBHwp6tS4fpay
Date: 03.12.2020
*/
echo "<!-- Identifier: CKrQsyvQRNJIMjZxb8JkkYoQTkJHqMI4jBcONhX1Yvsn9ZmgrFqRt9iQYNNMHYOZ6AHQhv7qFQUmBflxEe3DNMExHuVNDWFNboaIGLaaR391m8b4NApkI97ty4D8RaMG8WugCFGmeSBHwp6tS4fpay -->";




/* 
##############################################################################################
CODING
##############################################################################################
*/



//Imports
//Check key - $_GET["key"]; is read by keyit.php
include_once("keyit.php");
//Load options
include_once("config.php");


//Check if script is active
if($is_active==false){
    exit();
}




//Get vars to choose action

  
        //load and check GET vars
        $index = check_and_give_me_get_input("i"); //index


        $index_value = check_and_give_me_get_input("iv"); //index_value




//check if both vars are set
if (isset($index) == false ||  isset($index_value)== false){
    throw new Exception('GET vars index (i) and index_value (iv) are not set correctly, try it by manual.');
}else{
//run  get or set

//check if they are set
switch ($index) {
    case "get":
        //GET
        if (run_get($index_value,$old_time_definition)==true){}else{
           //Error
           throw new Exception('run_get function failed.'); 
        }
        break;
    case "set":
        //SET
        if (run_set($index_value)==true){}else{
            //Error
            throw new Exception('run_set function failed.'); 
         }

        break;
    default:
        throw new Exception('GET vars index (i) and index_value (iv) are not set correctly, try it by manual.');
}


}





// Functions


//Main Functions
function run_get($index_value, $old_time_definition){
    //make HTML comment
    echo "<!--Getting....-->";
    
                // generate file path
                $file = "data/" . $index_value . ".txt";
            
                //check if file exist
                if (test_file_existing($file)==false){

                    if($create_non_exsisting_files=true){
                            //create new dot file
                             //Write  timestamp in new file
                            write_in_file($file,"0");
                    }
                    else{
                            //Throw exception, user should add file
                        throw new Exception('index: ' . $index_value . " unknown. Please create it first.");
                    }
                }

                //Open File
                $information_file = read_from_file($file);

                //Get now timestamp
                $date = new DateTime();
                $timestamp_now = $date->getTimestamp();

                //calculate time diff
                $time_diff = $timestamp_now - $information_file ;


                // Check if older than 
                if ($information_file + ($old_time_definition) < $timestamp_now){



                //Last updtae is older than x time
                echo "Older than " . $old_time_definition . "sec. Timediff: " . $time_diff . " sec." ;


                }else{
                // Last update is NOT older than x time
                echo "Last update " . $information_file . "Timediff: " . $time_diff . " sec."  ;


                }


            
            //Secure file
            secure_file($file);


            //giveback ok
            return true;


}


function run_set($index_value){
    //make HTML comment
    echo "<!--Setting....-->";

    
    // generate file path
    $file = "data/" . $index_value . ".txt";
            

    //Get now timestamp
    $date = new DateTime();
    $timestamp_now = $date->getTimestamp();


    //Write update timestamp in file
    write_in_file($file,$timestamp_now);


    // Giveout OK
    echo "OK: " .     $timestamp_now ;


    //Secure file
    secure_file($file);


    //return ok
    return true;
}





// Subfunctions


function check_and_give_me_get_input($get_var_name_input){

    if ((isset($_GET[$get_var_name_input])) && (!empty($_GET[$get_var_name_input]))) {

        if(ctype_alnum($_GET[$get_var_name_input])==true){
            //allright
            return $_GET[$get_var_name_input];
        }else{
                            // Get Var is empty
                            throw new Exception('GET var: ' . $get_var_name_input . " are not only numbers or letters.");
        }

    }else{
            // Get Var is empty
            throw new Exception('GET var: ' . $get_var_name_input . " is empty.");
    }

}
function read_from_file($file_name){

    try {
//Open File
        $myfile = fopen($file_name, "r") or die("Unable to open file!:" . $file_name);

        //Read File 
        $information =  fread($myfile,filesize($file_name));
        //Close file
        fclose($myfile);


        return $information;
    } catch (Exception $e) {
        throw new Exception( $e->getMessage());
    }

}


function write_in_file($file_name,$text){

    try {

        $myfile = fopen($file_name, "w") or die("Unable to open file!:" . $file_name);
        fwrite($myfile, $text);
        fclose($myfile);

        return true;

    } catch (Exception $e) {
        throw new Exception( $e->getMessage());
    }

}


function test_file_existing($file_name){

    if (file_exists($file_name)) {
       return true;
    } else {
       return false;
    }

}




function secure_file($file_path){
    try {
        chmod($file_path, 0600);
    } catch (Exception $e) {
        throw new Exception( "WARNING: The program was not able to secure the " . $file_path . " Errordetails:" . $e->getMessage());
    }
    }



?>