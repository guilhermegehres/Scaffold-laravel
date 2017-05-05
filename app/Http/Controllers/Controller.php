<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use App\;
class Controller extends Controller
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

    public function get($id = null){
        if(!empty($id)){
            return json_encode(::find($id), JSON_PRETTY_PRINT);
        }
        return json_encode(::all(), JSON_PRETTY_PRINT);
    }

    public function store(Request $r ,$id = null){
        
        try{
            if(!empty($id)){
                $ = ::find($id);
            }else{
                $ = new ();
            }

            			$->id_product = $r->input("id_product");
			$->product_name = $r->input("product_name");
			$->product_price = $r->input("product_price");
			$->product_description = $r->input("product_description");
			$->product_amount = $r->input("product_amount");
			$->product_date_created = $r->input("product_date_created");
			$->is_active = $r->input("is_active");
			$->created_at = $r->input("created_at");
			$->updated_at = $r->input("updated_at");
            

            $->save();
            return json_encode($this->success , JSON_PRETTY_PRINT);
        }catch(Exception $e){
            return json_encode($this->error, JSON_PRETTY_PRINT);
        }
    }

    public function delete($id){
        try{
            ::destroy($id);
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