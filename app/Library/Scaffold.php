<?php 
namespace App\Library;

use Illuminate\Support\Facades\DB;

class Scaffold{
    
    private $table;

    private $stringCampos = "**CAMPOS**";
    
    private $stringRotas = "//**ROTAS**";

    private $stringHasMany = "//**HASMANY**";

    private $stringBelongsTo = "//**BELONGSTO**";

    private $dadosFormatados;

    private $dadosModel = [
        "class" => "**CLASS**",
        "table" => "**TABLE**"
    ];

    private $ignore;


//==============functions

    public function setTable($table){
        $this->table = $table;
    }

    public function generateCrud($table, $ignore){
        $this->table = $table;
        $this->ignore = $ignore;
        $this->setDadosFormatado();
        $this->generateController();
        $this->generateRoute();
        $this->generateModel();
        $this->generateHasMany();
        $this->generateBelongTo();
    }

    public function generateHasMany(){
        $dataBaseStringTables = "Tables_in_".env('DB_DATABASE');
        $table = null;
        $tables = DB::select('show tables');
        $hasManyTables = [];
        //Descobre quais tabelas possuem o id da tabela passada como parametro no comando, deve estar no padrão 'id_tabela''
        foreach($tables as $tableBD){
            if($tableBD->$dataBaseStringTables != $this->table){
                $columns = DB::select('show columns from ' . $tableBD->$dataBaseStringTables);   
                foreach($columns as $column){
                    if($column->Field == "id_$this->table"){
                        $hasManyTables[] = $tableBD->$dataBaseStringTables; 
                    }
                } 
            }
        }
        $hasMany = null;
        $model = file_get_contents(app_path().'/'.$this->dadosFormatados["class"].".php");
        //gera no model que foi criado a partir do parametro do comando todos os relacionamentos hasMany
        foreach($hasManyTables as $relation){
            $hasMany = file_get_contents(storage_path()."/templates/has-many-template");
            $dadosTabelaFormatados = $this->getDadosFormatados($relation);
            foreach($this->dadosModel as $key => $value){
                $hasMany = str_replace($value, $dadosTabelaFormatados[$key], $hasMany);
            }
            $model = str_replace($this->stringHasMany, $hasMany, $model);
            file_put_contents (app_path().'/'.$this->dadosFormatados["class"].".php", $model);
        }
    }

    public function generateBelongTo(){
        $columns = DB::select('show columns from ' . $this->table);
        $belongTo = [];
        foreach($columns as $column){
            $belongsToTemplate = file_get_contents(storage_path()."/templates/belongs-to-template");
            if(strpos($column->Field, "id_") === 0){
                $table = substr($column->Field, 3, strlen($column->Field)-1);
                $dadosFormatados = $this->getDadosFormatados($table);
                foreach($this->dadosModel as $key => $value){
                    $belongsToTemplate = str_replace($value, $dadosFormatados[$key], $belongsToTemplate);
                }
                $belongTo [] = $belongsToTemplate;
            }
        }
        $model = file_get_contents(app_path().'/'.$this->dadosFormatados["class"].".php");

        foreach($belongTo as $key){
            $model =  $model = str_replace($this->stringBelongsTo, $key, $model);
        }
        
        file_put_contents (app_path().'/'.$this->dadosFormatados["class"].".php", $model);
    }

    public function generateRoute(){
        $routeTemplate = file_get_contents(storage_path()."/templates/route-template");

        foreach($this->dadosModel as $key => $value){
            $routeTemplate = str_replace($value, $this->dadosFormatados[$key], $routeTemplate);
        } 

        $rotas = file_get_contents(base_path()."/routes/api.php");
        $rotas = str_replace($this->stringRotas, $routeTemplate, $rotas);
        file_put_contents (base_path().'/routes/api.php', $rotas);
    }

    public function generateController(){
        $columns = DB::select('show columns from ' . "produtos");
        $controllerTemplate = file_get_contents(storage_path()."/templates/controller-template");
        
        foreach($this->dadosModel as $key => $value){
            $controllerTemplate = str_replace($value, $this->dadosFormatados[$key], $controllerTemplate);
        }
        $inserts = "";
        foreach($columns as $column){
            //gera uma linha semelhante à -> '$produto->id_product = $r->input("id_product");' com os dados da coluna no banco
            if($this->verifyValidFields($column->Field))
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

    public function verifyValidFields($field){
        foreach($this->ignore as $value){
            if(strpos($field , $value) !== false ){
                return false;
            }
        }
        return true;
    }

    private function setDadosFormatado(){
        $class = strtoupper(substr($this->table, 0,1)).substr($this->table, 1, count(count_chars($this->table)));
        $this->dadosFormatados = [
            "class" => $class,
            "table" => $this->table
        ];
    }

    private function getDadosFormatados($table){
        $class = strtoupper(substr($table, 0,1)).substr($table, 1, count(count_chars($table)));
        return [
            "class" => $class,
            "table" => $table
        ];
    }

}
