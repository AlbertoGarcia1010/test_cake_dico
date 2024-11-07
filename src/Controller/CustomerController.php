<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Exception;

class CustomerController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function index() {
        try{
            
            // $this->viewBuilder()->disableAutoLayout();

            // $clientes = $this->Customer->getAll();
            $clientes = [];

            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $clientes];
            
        } catch (Exception $e) {
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        $this->response->withType('application/json; charset=UTF-8');
		$this->response->withStringBody(json_encode($response));
                                        
		return $this->response;
    }

    public function create(){
        try{
            $customHeaderValue = $this->request->getHeaders();
            $cliente = $this->Customer->newEmptyEntity();

            if($this->request->is('post')){
                $cliente = $this->Customer->patchEntity($cliente, $this->request->getData());
            
    
                if($this->Customer->save($cliente)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                    return $this->redirect(['action' => 'index']);
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('rol'));
        } catch (Exception $e) {
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
    }
}
