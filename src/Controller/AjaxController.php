<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 *
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AjaxController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function validate()
    {   
        $this->layout = 'ajax'; 
        $this->render(false);

        $file = $this->request->data['image'];

        if (isset($file["type"])) {
            $validextensions = array("jpeg", "jpg");
            $temporary = explode(".", $file["name"]);
            $file_extension = end($temporary);
            //Unique file name
            $file['name'] = time().".".$file_extension;

            if ((($file["type"] == "image/jpg") || ($file["type"] == "image/jpeg")
            ) && ($file["size"] < 100000) //Approx. 100kb files can be uploaded. for validation
                 && in_array($file_extension, $validextensions)) {
                if ($file["error"] > 0) {
                    $result = json_encode(array('code'=> $file["error"], 'data' => array('success'=> true, 'error'=> false)));
                } else {
                        $sourcePath = $file['tmp_name']; // Storing source path of the file in a variable
                        $targetPath = WWW_ROOT . 'upload\\'.$file['name']; // Target path where file is to be stored
                        move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
                        //SAVE INTO DB
                        $result = json_encode(array('code'=>'', 'data' => array('success'=> true, 'img'=> $file['name'] ,'error'=> NULL)));
                    
                    }
            } else {
                $result = json_encode(array('code'=> $file["error"], 'data' => array('success'=> false, 'error'=> 'Invalid file Size or Type of image !')));
            }
        }

        
        $this->response->type('json');
        $this->response->body($result);
        return $this->response;
    }


}
