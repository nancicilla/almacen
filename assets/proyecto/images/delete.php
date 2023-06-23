<?php

/*
 * Delete Files
 */

delete_file();
/**
 * Elimina un archivo subido
 */
function delete_file(){
    ob_clean();   
    $file = $_POST['image_object_id'];

    if(unlink($file)){
        $response = json_encode( array(
	    'success' => true           
	)
    );
    } 
    else {
        $writeable = (is_writable($file))? "YES" : "NO";
    	$exist = (file_exists($file))? "YES" : "NO";
	    $response = json_encode( array(
    	        'error'		=> FALSE,
    		'file'		=> $file,
    		'writable'	=> $writeable,
    		'exist'		=> $exist
		)
	);
    }
    // response output
    header( "Content-Type: application/json" );
    echo $response;
    // IMPORTANT: don't forget to "exit"
    exit;
}

