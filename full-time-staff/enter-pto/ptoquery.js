//variable for checking form validity

var HoursReady;
var TypeReady;
var HoursEntry;


//checks if name is correctly in list
function checkName(){

    var nameList = [];
    
    var optional = document.getElementById("staff-list").options
    for(var i=0;i<optional.length;i++){

        nameList[i] = optional[i].value;

    }
    

    var nameEntry =  document.getElementById("selected-name");

    if(nameEntry.value ==""){

        var name_element = document.getElementById("name_select_reminder");
        name_element.innerHTML = "Please select your name!";
        name_element.scrollIntoView(false);
        nameEntry.style="box-shadow: inset 0px 0px 3px #EA7186;"
        NameReady = false;
        

    }

    else if(!nameList.includes(nameEntry.value)){

        var name_element = document.getElementById("name_select_reminder");
        name_element.innerHTML = "Please enter/select a name exactly as in list";
        name_element.scrollIntoView(false);
        nameEntry.style="box-shadow: inset 0px 0px 3px #EA7186;"
        NameReady = false;

    }

    else{
        var name_element = document.getElementById("name_select_reminder");
        name_element.innerHTML = "";
        nameEntry.style="box-shadow: inset 0px 0px 3px #d6dce7;"
        NameReady = true;


    }


}


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

    if($('input[name=choice]:checked').length > 0){
        TypeReady = true;
        console.log("okay_type");
    
    }
    else{
        TypeReady = false;
        console.log("Type_not_okay");

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

    checkName();

    checkTimeCorrect();
    checkTypeCorrect();

    if(TypeReady == false){
        alert("Please select one hour type, either PTO or Holiday!");

    }
    else if(HoursReady == false){
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

//detecting changes from name input

$("#selected-name").change(function() {
    checkName();
  });
