<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Produtos extends Model
{
    //
    protected $table = 'produtos';

//Lista de BelongsTo de produtos

public function Pedido()
{
    return $this->belongsTo('App\Pedido', 'id_pedido');
}

//**BELONGSTO**

//Lista de HasMany de produtos

public function teste()
{
    return $this->hasMany('App\Teste'/*, 'id_teste'*/);
}

//**HASMANY**
    
}