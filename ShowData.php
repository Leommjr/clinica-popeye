<?php
declare(strict_types=1);

class ShowData
{
    protected $stmt;
    
    
    
    public function fn($row)
    {
        $data = "";
        foreach ($row as $col)
        {
            $data .= "<td>$col</td>"."\n";
        }
        return $data;
    }
    public function rotulo(string $tipo)
    {
        $data = "";
        $q = "Codigo Medico";
        $pessoa = "<tr>"."\n"."\t"."<th>#</th>"."\n"."\t"."<th>Nome</th>"."\n"."\t"."<th>Email</th>"."\n"."\t"."<th>Numero</th>"."\n"."\t"."<th>CEP</th>"
                            ."\n"."\t"."<th>Logradouro</th>"."\n"."\t"."<th>Bairro</th>"."\n"."\t"."<th>Cidade</th>"."\n"."\t"."<th>Estado</th>";
        switch($tipo){
            default:
            case "Funcionario":
                    $data .= $pessoa."\n"."\t"."<th>Data de Contrato</th>"."\n"."\t"."<th>Salário</th>"."\n"."\t"."<th>Hash Senha</th>"."\n"."</tr>";
                    return $data;
            case "Paciente":
                    $data .= $pessoa."\n"."\t"."<th>Peso</th>"."\n"."\t"."<th>Altura</th>"."\n"."\t"."<th>Tipo Sanguineo</th>"."\n"."</tr>";
                    return $data;
            case "Medico":
                    $data .= $pessoa."\n"."\t"."<th>Data de Contrato</th>"."\n"."\t"."<th>Salário</th>"."\n"."\t"."<th>Hash Senha</th>"."\n"."<th>Especialidade</th>".
                             "\n"."\t"."<th>CRM</th>"."\n"."</tr>";
                    return $data;
            case "Endereco":
                    $data .= "<tr>"."\n"."\t"."<th>#</th>"."\n"."\t"."<th>CEP</th>"."\n"."\t"."<th>Logradouro</th>"."\n"."\t"."<th>Bairro</th>"."\n"."\t"."<th>Cidade</th>".
                             "\n"."\t"."<th>Estado</th>"."\n"."</tr>";
                    return $data;
            case "Meus":
                    $q = "Nome Medico";
            case "Agenda":
                    $data .= "<tr>"."\n"."\t"."<th>#</th>"."\n"."\t"."<th>Data Agendamento</th>"."\n"."\t"."<th>Horário</th>"."\n"."\t"."<th>Nome</th>"."\n"."\t"."<th>Email</th>".
                             "\n"."\t"."<th>Telefone</th>"."\n"."\t"."<th>$q</th>"."\n"."</tr>";
                    return $data;
        }
    }
  
    public function __construct($stmt)
    {
        $this->stmt = $stmt;
    }

    public function showTable(string $tipo)
    {
        $i = 0;
        echo "<div class=\"table-responsive\">";
        echo "<table class=\"table table-dark table-bordered table-sm table-hover\">"."\n";
        echo $this->rotulo($tipo);
        while($row = $this->stmt->fetch())
        {
            $i += 1;
            //$size  = count($row);
            //$size = floor(12/$size); Tentativa de arrumar o layout com bootstrap
            echo <<<HTML
            <tr>
                <td>{$i}</td>
                {$this->fn($row)} 
            </tr>
            HTML;
        }
        echo "\n"."</table>";
        echo "</div>";
    }
}