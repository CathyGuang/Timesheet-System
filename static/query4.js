
//variable that checks if name entry is ready 
var NameReady = true;


//checks if name is correctly in list
function checkName(){


    var nameList = [];
    
    var optional = document.getElementById("volunteer-list").options
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
        nameEntry.style="box-shadow: inset 0px 0px 0px #d6dce7;"
        NameReady = true;


    }



}

function submitted() {

    checkName();
    //checkJobSelect();

    if(NameReady == false){
        console.log("innn");
        if(NameReady == false){

            alert("Please select or enter a name in the staff list");
            
        }
        return;

    }
    
    else{

        var confirmed = confirm('Are you sure you want to submit?');

        if (confirmed == true){

            document.getElementById('myform').submit(function(e){   

                window.location.href = 'view-hours.php'; 
            });

        
        }


    }

    
    
}


//detecting changes from name input

$("#selected-name").change(function() {
    checkName();
});

$("#selected-job").change(function() {
    checkJob();
});

$("#selected-hour").change(function() {
    checkHour();
});