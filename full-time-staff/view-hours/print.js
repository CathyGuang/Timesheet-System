

function change(obj){

    var valued = obj.value;

    var confirmed = confirm('Are you sure you want to change this data?'+valued);

    if (confirmed == true){

         window.location.href = 'change_data.php';
         localStorage.setItem('Change_Value', valued);

    }

}

// today's date

var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = mm + '/' + dd + '/' + yyyy;


var php_var = "<?php echo $_POST['staff'];?>";

function genPDF(){

    var doc = new jsPDF();

    doc.text(20,20,"TEST!");
    doc.addPage();
    doc.text(20,20,"TEST");
    doc.save(today+php_var+".pdf");


  };



