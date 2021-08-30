

function change(obj){

    var valued = obj.value;

    var confirmed = confirm('Are you sure you want to change this data?'+valued);

    if (confirmed == true){

         window.location.href = 'change_data.php';
         localStorage.setItem('Change_Value', valued);

    }

}


function genPDF(){

    var doc = new jsPDF();

    doc.text(20,20,"TEST!");
    doc.addPage();
    doc.text(20,20,"TEST");
    doc.save("Test.pdf");


  };



