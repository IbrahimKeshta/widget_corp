<?php

$errors = array();

function fieldname_as_text($fieldname){
    $fieldname = str_replace("_", " ", $fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
}
// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value)
{
  return  isset($value) && $value !== "";
}

function validate_presences($require_fields){
    global $errors; 
    foreach ($require_fields as $field ) {
        $value = trim($_POST[$field]);
        if(!has_presence($value)){
            $errors[$field] = fieldname_as_text($field) . " Can't be blank";
        }
    }
}

// * string length
// max length
function has_max_length($value , $max){
    return strlen($value) <= $max;
}


function validate_max_length($fields_with_max_length){
    // using an assoc. array
    global $errors;
    foreach($fields_with_max_length as $field => $max){
        $value = trim($_POST[$field]);
        if(!has_max_length($value , $max)){
            $errors[$field] = fieldname_as_text($field) . " is too long";
        }
    }
}
// * inclusion in a set
function has_inclusion_in($value,$set){
    return in_array($value,$set);
}


/*
function form_errors($errors=array())
 { $output = "";
    if (!empty($errors)) {
        $output  =  "<div class=\"error\">";
        $output .=  "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>{$error}</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}
*/

?>
