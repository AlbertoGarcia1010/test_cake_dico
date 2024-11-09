<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Exception;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

class ProductController extends Controller
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
            
            $productTable = TableRegistry::getTableLocator()->get('Product');

            // Get query parameters sent by DataTables
            $start = $this->request->getQuery('start');
            $length = $this->request->getQuery('length');
            $search = $this->request->getQuery('search')['value'];
            Log::info("search: $search");


            if($search == null){
                $query = $this->Product->find('all');
            }else{
                $query = $this->Product->find()->where([
                    'OR' => [
                        'Product.upc LIKE' => '%'. $search .'%',
                        'Product.existencia LIKE' => '%'. $search .'%',
                    ]
                ]);
            }
            
            Log::info("Query: $query");

            // Get total number of filtered records
            $totalFiltered = $query->count();

            // Get total number of records in the table
            $totalData = $productTable->find()->count();

            // Get the actual data
            $products = $query->all()->toArray();
            Log::info("Products: ".json_encode($products));

            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    $product->upc,
                    $product->descripcion,
                    $product->costo,
                    $product->precio,
                    $product->existencia,
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
            $idProduct = $this->request->getQuery('idProduct');
            Log::info("idProduct: $idProduct");

            $product = $this->Product->get($idProduct);
            Log::info("product: $product");

            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $product];
            
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
            $producto = $this->Product->newEmptyEntity();

            if($this->request->is('post')){
                $producto = $this->Product->patchEntity($producto, $this->request->getData());
            
    
                if($this->Product->save($producto)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                    return $this->redirect(['action' => 'index']);
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('producto'));
        } catch (Exception $e) {
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
    }

    public function update(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idProduct = $this->request->getData('upcEdit');
            $descripcion = $this->request->getData('descriptionEdit');
            $costo = $this->request->getData('costEdit');
            $precio = $this->request->getData('priceEdit');
            $existencia = $this->request->getData('inventoryEdit');

            Log::info("idProduct: $idProduct");

            $product = $this->Product->get($idProduct);
            $product->upc = $idProduct;
            $product->descripcion = $descripcion;
            $product->costo = $costo;
            $product->precio = $precio;
            $product->existencia = $existencia;

            Log::info("product: $product");

            if($this->request->is('post')){
                $product = $this->Product->patchEntity($product, $this->request->getData());
    
                if($this->Product->save($product)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('product'));
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $product];
            
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
            $idProduct = $this->request->getData('idProduct');
            Log::info("idProduct: $idProduct");

            $product = $this->Product->get($idProduct);
            Log::info("product: $product");

            if($this->request->is('post')){    
                if($this->Product->delete($product)){
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
