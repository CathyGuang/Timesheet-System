//variable for checking form validity

var HoursReady;
var TypeReady;
var TypeEntry;
var HoursEntry;

function checkTimeCorrect(){

    HoursEntry = document.getElementById("quantity").value;
    console.log(HoursEntry);
    
    if(HoursEntry== ""){
        HoursReady = false;
        console.log("None_hours");
    
    }
    else if((HoursEntry*100)%25 != 0){
        HoursReady = false;
        console.log("Math_Incoorect");
    }
    else{
        HoursReady = true;
        console.log("okay");
    }
}


function checkTypeCorrect(){


    TypeEntry = document.getElementsByName("choice").value;
    console.log(TypeEntry);

    if(HoursEntry.value ==""){
        TypeReady = false;
        console.log("None_type");
    
    }

    else{

        TypeReady = false;
        console.log("Type_okay");

    }




}

//canceled function:

function canceled(){

    var confirmed = confirm('Are you sure you want to cancel? Your input would not be saved');

        if (confirmed == true){

            window.location.href = '/full-time-staff/index.php';
        }


}

//submitted function:
function submitted() {

    checkTimeCorrect();
    checkTypeCorrect();

    if(HoursReady == false){

        alert("Please enter a valid hour with 15 minute (.25) interval");
        
    }

    else{
        var confirmed = confirm('Are you sure you want to submit?');

        if (confirmed == true){

            document.getElementById('myform').submit(function(e){    

                window.location.href = 'enter-pto.php'; 
            });

        
        }

    }


}
