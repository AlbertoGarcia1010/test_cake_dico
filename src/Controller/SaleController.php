<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Exception;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

class SaleController extends Controller
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

        $this->loadModel('Employee');
        $this->loadModel('Customer');
        $this->loadModel('Product');
        $this->loadModel('Sale');
        $this->loadModel('SaleDetail');



        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    public function index() {

    }

    public function create(){
        try{

            $employees = $this->Employee->find('list', [
                'keyField' => 'id',
                'valueField' => 'nombre'
            ])->toArray();

            $customers = $this->Customer->find('list', [
                'keyField' => 'id',
                'valueField' => 'nombre'
            ])->toArray();

            $products = $this->Product->find('list', [
                'keyField' => 'upc',
                'valueField' => 'descripcion'
            ])->toArray();

        
            $this->set(compact('employees'));
            $this->set(compact('customers'));
            $this->set(compact('products'));


            $sale = $this->Sale->newEmptyEntity();
            $newSaleId = $this->request->getQuery('newSaleId'); 
            Log::info("newSaleId: $newSaleId");
  
            
            $product = $this->Product->newEmptyEntity();

            
            $idCustomer = $this->request->getData('id_cliente');
            $idEmployee = $this->request->getData('id_empleado');
            $idProduct = $this->request->getData('id_producto');
            $idSale = $this->request->getData('idSale');
            Log::info("idProduct: $idProduct");

            if($idProduct != null){
                $query = $this->Product->find('all', [
                    'conditions' => ['Product.upc ' => (string)$idProduct]
                ]);
                
                $product = $query->first();
                Log::info("product: $product");
            }

            if($newSaleId == null || $newSaleId == 0){
                $sale->id_empleado = $idEmployee;
                $sale->id_cliente = $idCustomer;
                $sale->estatus = 0;
                $sale->total =  $product->precio ?? 0;  
            } else{
                $saleData = $this->Sale->get($newSaleId);
                $sale->id = $saleData->id;
                $sale->total = floatval($saleData->total) + floatval($product->precio); 
            }     
            Log::info("sale: $sale");

            if($this->request->is('post')){
                if($this->Sale->save($sale)){
                    $newSaleId = $sale->id;
                    $saleDetail = $this->saveSaleDetail($sale->id, $idProduct);
                    $this->Flash->success(__('Se han guardado los datos.'));
                    return $this->redirect(['action' => 'create', '?' => ['newSaleId' => $newSaleId]]);

                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }

            $this->set(compact('sale','newSaleId'));

        } catch (Exception $e) {
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
            Log::error("Error: $e");

        }
    }

    public function saveSaleDetail($idSale, $idProduct){
        try{
            $saleDetail = $this->SaleDetail->newEmptyEntity();
            $product = $this->Product->newEmptyEntity();
            $product = $this->Product->get($idProduct);

            $query = $this->SaleDetail->find()->where([
                'AND' => [
                    'SaleDetail.id_venta =' => $idSale,
                    'SaleDetail.id_producto =' => $idProduct,
                ]
            ]);

            $saleDetails = $query->all()->toArray();
            if(count($saleDetails) > 0){
                $saleDetail = $saleDetails[0];
                $saleDetail->cantidad = $saleDetail->cantidad + 1;
            } else{
                $saleDetail->id_venta = $idSale;
                $saleDetail->id_producto = $idProduct;
                $saleDetail->precio = $product->precio;
                $saleDetail->cantidad = 1; // crear logica para obtener el valor anterior y sumar 1
            }
            

            if($this->SaleDetail->save($saleDetail)){
                return $saleDetail;
            }

        }catch(Exception $e) {

        }
    }

    public function getSaleById(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idSale = $this->request->getData('idSale');
            Log::info("idSale: $idSale");

            $sale = $this->Sale->get($idSale);
            Log::info("sale: $sale");

            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $sale];
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        
        return $this->response;
    }

    public function getSaleDetailByIdSale(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $saleDetailTable = TableRegistry::getTableLocator()->get('SaleDetail');

            $idSale = $this->request->getQuery('idSale');
            Log::info("idSale: $idSale");
            /*
            $query = $this->SaleDetail->find()->where([
                'SaleDetail.id_venta' => $idSale,
            ]);
            */

            $query = $this->SaleDetail->find('all')
            ->contain(['Product'])
            ->where(['SaleDetail.id_venta' => $idSale]);
            


            $saleDetails = $query->all()->toArray();
            Log::info("SaleDetails: ".json_encode($saleDetails));

             // Get total number of filtered records
             $totalFiltered = $query->count();

             // Get total number of records in the table
             $totalData = $saleDetailTable->find()->count();

            $data = [];
            foreach ($saleDetails as $saleDetail) {
                $data[] = [
                    $saleDetail->id,
                    $saleDetail->id_venta,
                    $saleDetail->id_producto,
                    $saleDetail->precio,
                    $saleDetail->cantidad,
                    $saleDetail->utilidad,
                    $saleDetail->product->descripcion,
                    $saleDetail->product->existencia

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

    public function increaseProduct(){
        try{
            $idSale = $this->request->getData('idSale');
            $idProduct = $this->request->getData('idProduct');

            $this->saveSaleDetail($idSale, $idProduct);

            $sale = $this->Sale->newEmptyEntity();

            $query = $this->Product->find('all', [
                'conditions' => ['Product.upc ' => (string)$idProduct]
            ]);
            
            $product = $query->first();

            $saleData = $this->Sale->get($idSale);
            $sale->id = $saleData->id;
            $sale->total = floatval($saleData->total) + floatval($product->precio); 

            if($this->Sale->save($sale)){
                $this->Flash->success(__('Se han guardado los datos.'));
                // return $this->redirect(['action' => 'create', '?' => ['newSaleId' => $newSaleId]]);

            }
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => ''];

        }catch(Exception $e){

        }

        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        
        return $this->response;
    }

    public function decreaseProduct(){
        try{
            $idSale = $this->request->getData('idSale');
            $idProduct = $this->request->getData('idProduct');

            $this->removeSaleDetail($idSale, $idProduct);

            $sale = $this->Sale->newEmptyEntity();

            $query = $this->Product->find('all', [
                'conditions' => ['Product.upc ' => (string)$idProduct]
            ]);
            
            $product = $query->first();

            $saleData = $this->Sale->get($idSale);
            $sale->id = $saleData->id;
            $sale->total = floatval($saleData->total) - floatval($product->precio); 

            if($this->Sale->save($sale)){
                $this->Flash->success(__('Se han guardado los datos.'));
                // return $this->redirect(['action' => 'create', '?' => ['newSaleId' => $newSaleId]]);

            }
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => ''];

        }catch(Exception $e){

        }

        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        
        return $this->response;
    }

    public function removeSaleDetail($idSale, $idProduct){
        try{
            $saleDetail = $this->SaleDetail->newEmptyEntity();

            $query = $this->SaleDetail->find()->where([
                'AND' => [
                    'SaleDetail.id_venta =' => $idSale,
                    'SaleDetail.id_producto =' => $idProduct,
                ]
            ]);

            $saleDetails = $query->all()->toArray();
            if(count($saleDetails) > 0){
                $saleDetail = $saleDetails[0];
                $saleDetail->cantidad = $saleDetail->cantidad - 1;
            } 

            if($this->SaleDetail->save($saleDetail)){
                return $saleDetail;
            }

        }catch(Exception $e) {

        }
    }

    public function chargeSale(){
        try{
            $idSale = $this->request->getData('idSale');
            $sale = $this->Sale->newEmptyEntity();
            
            //Change estatus to 1
            $saleData = $this->Sale->get($idSale);
            $sale->id = $saleData->id;
            $sale->estatus = 1; 

            if($this->Sale->save($sale)){
                //decrease Products to Inventory
                // get All Products
                $query = $this->SaleDetail->find('all')
                ->contain(['Product'])
                ->where(['SaleDetail.id_venta' => $idSale]);

                $saleDetails = $query->all()->toArray();
                Log::info("SaleDetails: ".json_encode($saleDetails));

                foreach ($saleDetails as $saleDetail) {
                    $idProduct = $saleDetail->id_producto;
                    $product = $this->Product->get($idProduct);
                    $product->existencia = $product->existencia - $saleDetail->cantidad;
                    if($this->Product->save($product)){
                        $this->Flash->success(__('Se han guardado los datos.'));
                    }
                    $this->Flash->error(__('Hubo un error al guardar los datos'));
                }
            }
            // if all is success
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => ''];

        }catch(Exception $e){
            $response = ['success' => false, 'metadata' => ['id' => -2, 'message' => 'Request was successful'], 'data' => ''];
        }

        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        
        return $this->response;
    }

    public function cancelSale(){
        try{
            $idSale = $this->request->getData('idSale');
            $sale = $this->Sale->newEmptyEntity();
            
            //Change estatus to 1
            $saleData = $this->Sale->get($idSale);
            $sale->id = $saleData->id;
            $sale->estatus = 2; 

            if($this->Sale->save($sale)){
                //decrease Products to Inventory
                // get All Products
                $query = $this->SaleDetail->find('all')
                ->contain(['Product'])
                ->where(['SaleDetail.id_venta' => $idSale]);

                $saleDetails = $query->all()->toArray();
                Log::info("SaleDetails: ".json_encode($saleDetails));

                foreach ($saleDetails as $saleDetail) {
                    $idProduct = $saleDetail->id_producto;
                    $product = $this->Product->get($idProduct);
                    $product->existencia = $product->existencia + $saleDetail->cantidad;
                    if($this->Product->save($product)){
                        $this->Flash->success(__('Se han guardado los datos.'));
                    }
                    $this->Flash->error(__('Hubo un error al guardar los datos'));
                }
            }
            // if all is success
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => ''];

        }catch(Exception $e){
            $response = ['success' => false, 'metadata' => ['id' => -2, 'message' => 'Request was successful'], 'data' => ''];
        }

        $this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($response));
        
        return $this->response;
    }
}
