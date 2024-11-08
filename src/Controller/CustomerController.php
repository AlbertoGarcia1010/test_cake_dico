<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Exception;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

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

    }

    public function getAll(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            
            $customerTable = TableRegistry::getTableLocator()->get('Customer');

            // Get query parameters sent by DataTables
            $start = $this->request->getQuery('start');
            $length = $this->request->getQuery('length');
            $search = $this->request->getQuery('search')['value'];
            Log::info("search: $search");


            if($search == null){
                $query = $this->Customer->find('all');
            }else{
                $query = $this->Customer->find()->where([
                    'OR' => [
                        'Customer.name LIKE' => '%'. $search .'%',
                        'Customer.description LIKE' => '%'. $search .'%',
                    ]
                ]);
            }
            
            Log::info("Query: $query");
            //$query = $rolesTable->find()->where(['Roles.is_visible' => 1]);

            // Get total number of filtered records
            $totalFiltered = $query->count();

            // Get total number of records in the table
            $totalData = $customerTable->find()->count();

            // Get the actual data
            $customers = $query->all()->toArray();
            Log::info("Customers: ".json_encode($customers));

            $data = [];
            foreach ($customers as $customer) {
                $data[] = [
                    $customer->id,
                    $customer->nombre,
                    $customer->apellido,
                    $customer->direccion,
                    $customer->email,
                    $customer->usuario,
                    $customer->fecha_nacimiento,
                    //$customer->created->format('Y-m-d H:i:s')
                ];
            }

            // Return the data in JSON format
            $jsonData = [
                "draw" => intval($this->request->getQuery('draw')), // Draw counter sent by DataTables
                "recordsTotal" => $totalData, // Total number of records
                "recordsFiltered" => $totalFiltered, // Number of filtered records
                "data" => $data // Actual data to display
            ];
            
    
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $jsonData];
            
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }

        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        
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
    
            $this->set(compact('cliente'));
        } catch (Exception $e) {
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
    }
}
