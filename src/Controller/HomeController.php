<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Http\Client;

class HomeController extends Controller
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

    public function home(): void{
        
    }

    public function banxico() {
        $client = new Client();
        $response = $client->get('https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno', [], [
            'headers' => [
                'Bmx-Token' => 'c92a8b0616477f31fbe28efb42a087d272093b9befe342f944b6eb64aa8607e5', // Añade token de Banxico
            ]
        ]);

        // Devuelve la respuesta de Banxico como JSON
        return $this->response
            ->withType('application/json')
            ->withStringBody($response->getStringBody());
        
    }
}
