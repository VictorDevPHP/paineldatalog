<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamentos extends Model
{
    protected $table = 'equipamentos'; // Nome da tabela no banco de dados (se for diferente de 'equipamentos', ajuste conforme necessário)
    
    protected $fillable = ['id', 'nome', 'ip', 'versao_protocolo', 'status']; // Colunas preenchíveis em massa

    // Aqui você pode definir relacionamentos, acessores, mutadores ou outras configurações do modelo

    // Exemplo de um relacionamento (se houver)
    public function algumRelacionamento()
    {
        return $this->belongsTo(OutroModelo::class);
    }

    public function datalogs()
    {
        return $this->hasMany(Datalog::class, 'id_equipamento');
    }
    public $timestamps = false;

}
