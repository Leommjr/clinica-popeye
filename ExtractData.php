<?php
declare(strict_types=1);

class ExtractData
{
    protected $db;
    protected $tipo;

    private function executeQuery(string $sql) // Prepara a query recebida e executa
    {
        try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nome', "%{$nome}%");
            $stmt->execute();
            return $stmt;
        }
        catch (Exception $e) {
            throw $e;
        }

    }

    private function createQueryPessoa() // Insere os dados da tabela pessoa na query
    {
        $sql = 'SELECT nome, email, telefone, cep, logradouro, bairro, cidade, estado';
        return $sql;
    }
    private function createQueryFuncionario() // Insere os dados da tabela pessoa+funcionario na query
    {
        $sql = $this->createQueryPessoa();
        $sql .= ', data_contrato, salario, senha_hash';
        return $sql;
    }
    private function createQueryMedico() // Insere os dados da tabela pessoa+funcionario+medico na query
    {
        $sql = $this->createQueryFuncionario();
        $sql .= ', especialidade, crm';
        return $sql;
    }
    private function createQueryPaciente() // Insere os dados da tabela pessoa+paciente na query
    {
        $sql = $this->createQueryPessoa();
        $sql .= ', peso, altura, tipo_sanguineo';

    }
    private function useFuncionario(string $nome)
    {
        $sql = $this->createQueryFuncionario();
        $sql .= ' FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo WHERE nome LIKE :nome';
        return $sql;
    }
    private function usePaciente(string $nome)
    {
        $sql = $this->createQueryPaciente();
        $sql .= ' FROM pessoa INNER JOIN paciente ON pessoa.codigo = paciente.codigo WHERE nome LIKE :nome';
        return $sql;
    }
    private function useMedico(string $nome)
    {
        $sql = $this->createQueryMedico();
        $sql .= ' FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo
            INNER JOIN medico ON funcionario.codigo = medico.codigo WHERE nome LIKE :nome';
        return $sql;
    }

    public function __construct(PDO $db, string $tipo)
    {
        $this->db = $db;
        $this->tipo = $tipo;
    }

    public function getData(string $nome)
    {

        $sql = "";
        switch($this->tipo){
            case 'Funcionario':
                $sql = $this->useFuncionario($nome);
                break;
            case 'Medico':
                $sql = $this->useMedico($nome);
                break;
            case 'Paciente':
                $sql = $this->usePaciente($nome);
            default:
                break;
        }
        try{
            $stmt = $this->executeQuery($sql);
            return $stmt;
        }
        catch (Exception $e) {
            throw $e;
        }
    }

}