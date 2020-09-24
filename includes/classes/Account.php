<?php 

class Account{

    private $errorArray;

    private $curr_year;
    public function __construct(){
        $this->errorArray = array();
        $this->curr_year  = date("Y");
    }

    public function register($userEmail,$password1,$password2,$profileName,$contactNo,$date,$month,$year,$tnc){ 
        $this->validateEmail($userEmail);
        $this->validatePasswords($password1,$password2);
        $this->validateProfileName($profileName);
        $this->validateContact($contactNo);
        $this->validateDOB($date,$month,$year);
        $this->validateTnC($tnc);

        if(empty($this->errorArray)){
            //insert to db
            return true;
        }
        else{
            return false;
        }

    }

    public function getError($error){
        if(!in_array($error,$this->errorArray)){
            $error="";
        }
        // print_r($this->errorArray);
        return "<div class='error-msg'>$error</div>";
        // return print_r($this->errorArray);
    }

    private function validateEmail($em) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, "Email is invalid");
            return;
        }

        //TODO: Check that username hasn't already been used

    }

    private function validatePasswords($pw1,$pw2){
        if(!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $pw1)){
            array_push($this->errorArray, "Password should have 8-20 characters, atleast one Uppercase letter, atleast one number and atleast one special character!");
            return;
        }

        if($pw1 != $pw2){
            array_push($this->errorArray, "Your passwords don't match.");
            return;
        }

    }

    private function validateProfileName($pn){
        if(strlen($pn) >25 || strlen($pn) < 3 ){
            array_push($this->errorArray, "Profile name should must be between 3 and 25 characters.");
            return;
        }
    }

    private function validateContact($no){
        if(strlen($no)!=10){
            array_push($this->errorArray, "Contact number must have 10 digits only!");
            return;
        }

        if(!preg_match('/^[6-9]\d{9}$/', $no)){
            array_push($this->errorArray, "Contact number must start with 6,7,8 or 9!");
            return;
        }

    }

    private function validateDOB($d,$m,$y){
        if (!preg_match("/^[0-9]*$/",$y))
        {
            array_push($this->errorArray,"Invalid Year");
            return;
        }

        if((($this->curr_year-$y) >= 100 ) || ($y>=$this->curr_year)){
            array_push($this->errorArray, "Invalid Year");
            return;
        }

        if($m == '' || empty($m)){
            array_push($this->errorArray, "Month is required");
            return;
        }

        if(!checkdate($m,$d,$y)){
            array_push($this->errorArray, "Invalid date of birth");
            return;
        }

    }

    private function validateTnC($tnc){
        if(empty($tnc) || $tnc==''){
            array_push($this->errorArray, "Accept to the terms & conditions");
            return;
        }
    }

}

?>