<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Exception;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

class EmployeeController extends Controller
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
    }

    public function index() {

    }

    public function getAll(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            
            $employeeTable = TableRegistry::getTableLocator()->get('Employee');

            // Get query parameters sent by DataTables
            $start = $this->request->getQuery('start');
            $length = $this->request->getQuery('length');
            $search = $this->request->getQuery('search')['value'];
            Log::info("search: $search");


            if($search == null){
                $query = $this->Employee->find('all');
            }else{
                $query = $this->Employee->find()->where([
                    'OR' => [
                        'Employee.nombre LIKE' => '%'. $search .'%',
                        'Employee.apellido LIKE' => '%'. $search .'%',
                        'Employee.tekefono LIKE' => '%'. $search .'%',
                    ]
                ]);
            }
            
            Log::info("Query: $query");

            // Get total number of filtered records
            $totalFiltered = $query->count();

            // Get total number of records in the table
            $totalData = $employeeTable->find()->count();

            // Get the actual data
            $employees = $query->all()->toArray();
            Log::info("Employees: ".json_encode($employees));

            $data = [];
            foreach ($employees as $employee) {
                $data[] = [
                    $employee->id,
                    $employee->nombre,
                    $employee->apellido,
                    $employee->telefono,
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

    public function getById(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idEmployee = $this->request->getQuery('idEmployee');
            Log::info("idEmployee: $idEmployee");

            $employee = $this->Employee->get($idEmployee);
            Log::info("employee: $employee");

            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $employee];
            
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
            $empleado = $this->Employee->newEmptyEntity();

            if($this->request->is('post')){
                $empleado = $this->Employee->patchEntity($empleado, $this->request->getData());
            
    
                if($this->Employee->save($empleado)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                    return $this->redirect(['action' => 'index']);
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('empleado'));
        } catch (Exception $e) {
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
    }

    public function update(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idEmployee = $this->request->getData('idEmployee');
            $name = $this->request->getData('nameEdit');
            $apellido = $this->request->getData('lastNameEdit');
            $telefono = $this->request->getData('phoneEdit');

            Log::info("idEmployee: $idEmployee");

            $employee = $this->Employee->get($idEmployee);
            $employee->nombre = $name;
            $employee->apellido = $apellido;
            $employee->telefono = $telefono;

            Log::info("employee: $employee");

            if($this->request->is('post')){
                $employee = $this->Employee->patchEntity($employee, $this->request->getData());
    
                if($this->Employee->save($employee)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('employee'));
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $employee];
            
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        return $this->response;
    }

    public function delete(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idEmployee = $this->request->getData('idEmployee');
            Log::info("idEmployee: $idEmployee");

            $employee = $this->Employee->get($idEmployee);
            Log::info("employee: $employee");

            if($this->request->is('post')){    
                if($this->Employee->delete($employee)){
                    $this->Flash->success(__('Se han eliminado los datos.'));
                }
    
                $this->Flash->error(__('Hubo un error al eliminar los datos'));
            }
    
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => ''];
            
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        return $this->response;
    }
}
