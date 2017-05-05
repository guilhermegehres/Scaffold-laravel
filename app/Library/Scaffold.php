<?php 
namespace App\Library;

use Illuminate\Support\Facades\DB;

class Scaffold{
    
    private $table;
    private $dadosModel = [
        "class" => "**CLASS**",
        "table" => "**TABLE**"
    ];

    private $stringCampos = "**CAMPOS**";

    private $dadosFormatados;

    public function setTable($table){
        $this->table = $table;
    }

    public function generateCrud($table){
        $this->table = $table;
        $this->setDadosFormatado();
        $this->generateController();
        $this->generateModel();
    }

    public function generateRoute(){
        $routeTempplate = file_get_contents(storage_path()."/templates/controller-template");
    }

    public function generateController(){
        $columns = DB::select('show columns from ' . "produtos");
        $controllerTemplate = file_get_contents(storage_path()."/templates/controller-template");
        
        foreach($this->dadosModel as $key => $value){
            $controllerTemplate = str_replace($value, $this->dadosFormatados[$key], $controllerTemplate);
        }
        $inserts = "";
        foreach($columns as $column){
            //gera uma lionha semelhante à -> '$produto->id_product = $r->input("id_product");' com os dados da coluna no banco
            $inserts .= "\t\t\t$".$this->dadosFormatados["table"]."->".$column->Field.' = $r->input("'.$column->Field.'");'.PHP_EOL;
        }
        $controllerTemplate = str_replace($this->stringCampos, $inserts, $controllerTemplate);
        file_put_contents (app_path().'/Http/Controllers/'.$this->dadosFormatados["class"]."Controller.php", $controllerTemplate);
    }

    public function generateModel(){
        $modelTemplate = file_get_contents(storage_path()."/templates/model-template");
        
        foreach($this->dadosModel as $key => $value){
            $modelTemplate = str_replace($value, $this->dadosFormatados[$key], $modelTemplate );
        }
        file_put_contents (app_path().'/'.$this->dadosFormatados["class"].".php", $modelTemplate);
    }
/*
    public function generateRoute(){


        Route::get('/produto/{id?}', ['alias' => '/produto' , 'uses' => 'ProdutoController@getProdutos']);
        Route::post('/produto', ['alias' => '/produto' , 'uses' => 'ProdutoController@storeProduto']);
        Route::post('/produto/update/{id}', ['alias' => '/produto' , 'uses' => 'ProdutoController@storeProduto']);
        Route::post('/produto/filtro', ['alias' => '/produto' , 'uses' => 'ProdutoController@getProdutosByFiltro']);
        Route::delete('/produto/{id}', ['alias' => '/produto' , 'uses' => 'ProdutoController@deleteProduto']);
    }
*/

    private function setDadosFormatado(){
        $class = strtoupper(substr($this->table, 0,1)).substr($this->table, 1, count(count_chars($this->table)));
        $this->dadosFormatados = [
            "class" => $class,
            "table" => $this->table
        ];
    }

}
