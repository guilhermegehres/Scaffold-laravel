<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use App\Produtos;
class ProdutosController extends Controller
{
    //
    private $error = 
        [
            'error' => 'Error', 
            'message' => 'Um erro foi encontrado, verifique os campos e parâmetros passados'
        ];
    private $success = [
        'success' => 'success' 
    ];

    public function getProdutos($id = null){
        if(!empty($id)){
            return json_encode(Produtos::find($id), JSON_PRETTY_PRINT);
        }
        return json_encode(Produtos::all(), JSON_PRETTY_PRINT);
    }

    public function storeProdutos(Request $r ,$id = null){
        
        try{
            if(!empty($id)){
                $produtos = Produtos::find($id);
            }else{
                $produtos = new Produtos();
            }

            			$produtos->id = $r->input("id");
			$produtos->product_name = $r->input("product_name");
            

            $produtos->save();
            return json_encode($this->success , JSON_PRETTY_PRINT);
        }catch(Exception $e){
            return json_encode($this->error, JSON_PRETTY_PRINT);
        }
    }

    public function deleteProdutos($id){
        try{
            Produtos::destroy($id);
            return json_encode($this->success , JSON_PRETTY_PRINT);
        }catch(Exception $e){
            return json_encode($this->error, JSON_PRETTY_PRINT);
        }
    }

    /*
    public function getProdutosByFiltro(Request $r){
        try{
            $produtos = Produto::where(function ($query) use($r) {
                        $query->orWhere('product_name', 'like', "%".$r->product_name."%")
                        ->orWhere('product_description', 'like', "%".$r->product_description."%");
            })->get();
           
            return json_encode($produtos, JSON_PRETTY_PRINT);
        }catch(Exception $e){
            return json_encode($this->error, JSON_PRETTY_PRINT);
        }
    }
    */
}