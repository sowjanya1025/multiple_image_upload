<?php 
  include 'config/database.php'; 
 if(isset($_POST['submit'])){
 print_r($_POST);
 
 if($_POST['deletedids']!='')  
 {
  $del_ids_list = explode(",",$_POST['deletedids']);
  }
// print_r($del_ids_list);
// echo "<br>";

// print_r($_POST);
 //print_r($_FILES);
// print_r($_FILES['midias']['name']);
 
 $filenames_list = $_FILES['midias']['name'];
 print_r($filenames_list);
 echo "<br>";
 
 //count($del_ids_list);
 
 if(!empty($del_ids_list)) { 
 
 for($i=0;$i<count($del_ids_list);$i++)
 {
 	unset($filenames_list[array_search($del_ids_list[$i], $filenames_list)]);
 }
 }
  print_r($filenames_list);
 echo "<br>";
 
 //print_r($_POST['midiasUpload']);
// echo "----------------------------";
 
// if(is_array($_FILES))   
// {
// 		print_r($_FILES);
// 		 $total = count($_FILES['midias']['name']);
//		 echo $total;
//}

        
        $uploadsDir = "uploads/";
        $allowedFileType = array('jpg','png','jpeg');
        
        // Velidate if files exist
        if (!empty(array_filter($_FILES['midias']['name']))) {
            
            // Loop through file items
            foreach($_FILES['midias']['name'] as $id=>$val)
			{
               
			   if (in_array($_FILES['midias']['name'][$id], $filenames_list, TRUE)) { 
			    // Get files upload path
                $fileName        = $_FILES['midias']['name'][$id];
				echo $fileName;
                $tempLocation    = $_FILES['midias']['tmp_name'][$id];
                $targetFilePath  = $uploadsDir . $fileName;
                $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $uploadDate      = date('Y-m-d H:i:s');
                $uploadOk = 1;

                if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){
                            $sqlVal = "('".$fileName."', '".$uploadDate."')";
                        } else {
                            $response = array(
                                "status" => "alert-danger",
                                "message" => "File coud not be uploaded."
                            );
                        }
                    
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Only .jpg, .jpeg and .png file formats allowed."
                    );
                }
                // Add into MySQL database
                if(!empty($sqlVal)) {
                    $insert = $conn->query("INSERT INTO user (images, date_time) VALUES $sqlVal");
                    if($insert) {
                        $response = array(
                            "status" => "alert-success",
                            "message" => "Files successfully uploaded."
                        );
                    } else {
                        $response = array(
                            "status" => "alert-danger",
                            "message" => "Files coudn't be uploaded due to database error."
                        );
                    }
                }
			  }
            } // foreach

        } else {
            // Error
            $response = array(
                "status" => "alert-danger",
                "message" => "Please select a file to upload."
            );
        }
    

}
?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
function select(el) {
  img = el;
}
var img;
var input;
$(document).ready(function() {
  $("#midiasUpload").on('change', function() {
    var countFiles = $(this)[0].files.length;
    input = $(this)[0];
    console.log('Input value after upload: ', input.value)
    var imgPath = input.value;
    img = imgPath;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    var image_holder = $("#midiaDigital");
    image_holder.empty();
    if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
      if (typeof(FileReader) != "undefined") {
        for (let i = 0; i < countFiles; i++) {
		//alert(i);
          var reader = new FileReader();
          reader.onload = function(e) {
            $(image_holder).append('<div class="form-group row">' +
                                   '<div>' +
                                   '<div class="col-md-6">' +                             
                                   '<img src="' + e.target.result + '" class="imageThumb" onclick="select($(this))">' +
                                   '<input type="text" class="form-control input-sm" value="midiaDigitals[' + i + '].legenda" placeholder="Digitedigital"/>' + 
                                   '<a href="#" data-id="'+i+'" class="remove_field1">Remover</a>'  + //add input box
                                   '</div>' +
                                   '</div>' +
                                   '</div>'); 
          }
          image_holder.show();
          reader.readAsDataURL($(this)[0].files[i]);
        }
      } else {
        alert("stuff");
      }
    } else {
      alert("stuff");
    }
  });
   let delnames  = "he";
   var sub_array = [];
   var names = [];

$(midiaDigital).on("click",".remove_field1", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); 
    var deletedId=$(this).attr("data-id");
	//var delid = deletedId - 1;
	//alert(deletedId);
	//alert(delid);
	
	//var sub_array = [];
  //  var super_array =[];
  //  for (var i=1;i<=3;i++){
       // sub_array = sub_array.slice(0,sub_array.length);
     //   sub_array.push(i);
       // super_array.push(sub_array);
 //   }
 //   alert(sub_array);
	
	
   // const names = ["Banana"];
   
   // for (var i = 0; i < $("#midiasUpload").get(0).files.length; ++i) {
	for (var i = 0; i < $("#midiasUpload").get(0).files.length; ++i) {
     if(deletedId==i){
	 			alert(($("#midiasUpload").get(0).files[i].name));
				//sub_array.concat(($("#midiasUpload").get(0).files[i].name));
				//delnames += ($("#midiasUpload").get(0).files[i].name);
				
				//alert(delnames);
				names.push(($("#midiasUpload").get(0).files[i].name)); 
				 document.getElementById("deletedids").value = names;
				
	 //	$("#midiasUpload").splice(i, 1);

	 }
	 else{  //names.push($("#midiasUpload").get(0).files[i].name); 
	  }
    } //alert(names);
   // $("#test").val(names);
});   
  
}); </script>
</head>
    <form action="index5.php" method="post" enctype="multipart/form-data" class="mb-3">
	<input type="text" name="deletedids" id="deletedids" value="" />
	

<input id="midiasUpload" multiple="multiple" type="file" name="midias[]"  /> 
<div id="midiaDigital" style="margin-bottom: 100px;"></div>
      <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
        Upload Files
      </button>
</form>

<body>
</body>
</html>
