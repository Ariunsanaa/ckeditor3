<!DOCTYPE html>
<html lang="en">
<head>
    <title>CKEditor Classic Editing Sample</title>
    <!-- Make sure the path to CKEditor is correct. -->
    <script src="/ckeditor/ckeditor.js"></script>
    <style>
    #myform{
        width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    #myform img{
        width: 500px;
    }
    #editor1 img{
        width: 500px;
    }
    </style>
</head>
<style type="text/css">
    .cke_dialog_image_url 
    {
      display: none;
    }
    .cke_dialog_ui_input_select{
      display: none;
    }
    .cke_dialog_ui_select{
      display:none;
    }
  </style>
<body>
    <div id="myform">
    <form method="post">
        <p>
            My Editor:<br>
            <textarea name="content" id="editor1" ></textarea>
            <script>
                CKEDITOR.replace( 'content',{
                  filebrowserUploadUrl: "upck.php"
                } );

//                 CKEDITOR.on('dialogDefinition', function(ev) {
//     var dialogName = ev.data.name;
//     var dialogDefinition = ev.data.definition;

//     if (dialogName == 'image') {
//         var infoTab = dialogDefinition.getContents( 'info' );
//         infoTab.remove( 'txtBorder' ); //Remove Element Border From Tab Info
//         infoTab.remove( 'txtHSpace' ); //Remove Element Horizontal Space From Tab Info
//         infoTab.remove( 'txtVSpace' ); //Remove Element Vertical Space From Tab Info
//         infoTab.remove( 'txtWidth' ); //Remove Element Width From Tab Info
//         infoTab.remove( 'txtHeight' ); //Remove Element Height From Tab Info

//         //Remove tab Link
//         dialogDefinition.removeContents( 'Link' );
//         // Remove image info
//         //dialogDefinition.removeContents( 'info' );
//     }
// });

CKEDITOR.on('dialogDefinition', function(e) {
    if (e.data.name == 'image') {
        var dialog = e.data.definition;
        oldOnShow = dialog.onShow;
        dialog.onShow = function() {
             oldOnShow.apply(this, arguments);
             this.selectPage('Upload');
        };
    }
});

CKEDITOR.on('dialogDefinition', function(ev) {
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;
    console.log(dialogDefinition);
    if (dialogName == 'image') {
        var infoTab = dialogDefinition.getContents( 'info' );
        infoTab.remove( 'txtBorder' ); //Remove Element Border From Tab Info
        infoTab.remove( 'txtHSpace' ); //Remove Element Horizontal Space From Tab Info
        infoTab.remove( 'txtVSpace' ); //Remove Element Vertical Space From Tab Info
        infoTab.remove( 'txtWidth' ); //Remove Element Width From Tab Info
        infoTab.remove( 'txtHeight' ); //Remove Element Height From Tab Info
        // infoTab.remove( 'txtHeight' ); //Remove Element Height From Tab Info
        infoTab.remove( 'linkType');
        infoTab.remove( 'protocol');
        infoTab.remove('link');
        
        
        //Remove tab Link
        dialogDefinition.removeContents( 'Link' );
        //$('#cke_89_textInput').remove();
        // Remove image info
    
    }
});


            </script>
        </p>
        <p>
            <input type="submit">
        </p>
    </form>
    </div>
    <?php 
    
    if(isset($_POST['content'])){
        // Өгөгдлийн баазтай PDO-гээр холбогдох гэж байна 
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'mypdo2';


    // Set DSN 
    $dsn = 'mysql:host='.$host . ';dbname=' . $dbname;

    //Create a PDO instance 
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $body = $_POST['editor1'];

    $sql = 'INSERT INTO content(body) VALUES(:body)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['body'=>$body]);
    echo 'Post Added';
    }

    ?>
</body>
</html>