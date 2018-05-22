<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 *
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BooksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $books = $this->paginate($this->Books);

        $this->set(compact('books'));
    }

    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => []
        ]);

        $this->response->type('json');
        $this->response->body($book);
        return $this->response;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {   
        $book = $this->Books->newEntity();
        if ($this->request->is('ajax')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $result = json_encode(array('result' => 'success'));
                $this->response->type('json');
                $this->response->body($result);
                return $this->response;

               // return $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('book'));
    }


    public function edit($id = null)
    {
        if ($this->request->is('ajax')) {

            $booksTable = TableRegistry::get('Books');
            $book = $booksTable->get($id); // Return book with id
            $data = $this->request->getData();
    
            $book->title = $data['title'];
            $book->author = $data['author'];
            $book->released = $data['released'];
            $book->img_url = $data['img_url'];

            
            if ($booksTable->save($book)) {
                $result = json_encode(array('success' => true, 'error'=>''));
            }
            else{
                $result = json_encode(array('success' => false, 'error'=>'The book couldn\'t be saved. Please try again'));
            }
                $this->response->type('json');
                $this->response->body($result);
                return $this->response;
        }

    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
                $resultJ = json_encode(array('result' => 'success'));
                $this->response->type('json');
                $this->response->body($resultJ);
                return $this->response;
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function search(){
        $param = [];
        $books = [];

        $this->request->allowMethod(['post']);

        $booksTable = TableRegistry::get('Books');

        $data = $this->request->getData();

        foreach ($data as $key => $value) {
            if(strlen($value)){

                if($key!='year'){
                    $param[$key] = $value;
                }else{
                    $param["released LIKE"] = "%".$value."%";
                }

            }
        }
    
        $query = $booksTable ->find() ->select() ->where($param);

        foreach ($query as $book_data) {
            $book = array("id"=>$book_data['id'],"title"=>$book_data['title'],"author"=>$book_data['author'],"released"=>$book_data['released'],"img_url"=>$book_data['img_url']);
            $books[] = $book;
        }

        $jsonBoooks = json_encode($books);
        
        $this->response->type('json');
        $this->response->body($jsonBoooks);
        return $this->response;
    }
}
