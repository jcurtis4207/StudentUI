/*
* For each button in the login screen, pull user data from form and send to php and enable next html form entries
*/
function SubmitStudentData(){
    // ensure id and password were entered
    if(document.getElementById('student_id').value == ""){
        alert("Please Enter Student ID");
        return false;
    }
    if(document.getElementById('student_password').value == ""){
        alert("Please Enter Student Password");
        return false;
    }
    // pull data to send to php
    var form_data = new FormData();
    form_data.append('student_id', document.getElementById('student_id').value);
    form_data.append('student_password', document.getElementById('student_password').value);
    var request = new XMLHttpRequest();
    request.open('POST', "login-student-data.php");
    request.onload = function(){
        if(this.response == "Error"){
            alert("Student Password Incorrect");
        }
        else{
            // activate the CRN dropdown, instructor password field, and class submit button
            document.getElementById("crn_dropdown").disabled = false;
            document.getElementById("teacher_password").disabled = false;
            document.getElementById("class-button").disabled = false;
            // read data from php into array and remove empty elements
            var input = this.response;
            var array = input.split("@");
            array = array.filter(n => n);
            // reset crn dropdown
            var select = document.getElementById("crn_dropdown");
            select.options.length = 0;
            // populate crn dropdown with data from php
            for(index in array){
                select.options[select.options.length] = new Option(array[index], array[index]);
            }
        }
    };
    request.send(form_data);
    return false;
}

function SubmitClassData(){
    // ensure instructor password was entered
    if(document.getElementById('teacher_password').value == ""){
        alert("Please Enter Teacher Password");
        return false;
    }
    // pull data to send to php
    var form_data = new FormData();
    crn_index = document.getElementById('crn_dropdown').selectedIndex;
    crn_value = document.getElementById('crn_dropdown').options[crn_index].innerHTML;
    form_data.append('crn', crn_value);
    form_data.append('teacher_password', document.getElementById('teacher_password').value);
    var request = new XMLHttpRequest();
    request.open('POST', "login-class-data.php");
    request.onload = function(){
        if(this.response == "Lab_Error"){
            alert("No Labs Found");
        }else if(this.response == "Teacher_Error"){
            alert("Teacher Password Incorrect");
        }
        else{
            // activate the lab dropdown and rate button
            document.getElementById("lab_dropdown").disabled = false;
            document.getElementById("rate-button").disabled = false;
            // read data from php into array and remove empty elements
            var input = this.response;
            var array = input.split("@");
            array = array.filter(n => n);
            // reset crn dropdown
            var select = document.getElementById("lab_dropdown");
            select.options.length = 0;
            // populate crn dropdown with data from php
            for(index in array){
                select.options[select.options.length] = new Option(array[index], array[index]);
            }
        }
    };
    request.send(form_data);
    return false;
}