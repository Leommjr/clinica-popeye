<?php

class ExtractData
{
    protected $db;
    protected $tipo;

    private function executeQuery($sql, $nome) // Prepara a query recebida e executa
    {
        try
        {
            $stmt = $this->db->prepare($sql);
            if($nome !== "*")
                $stmt->bindValue(':nome', "%{$nome}%");
            $stmt->execute();
            return $stmt;
        }
        catch (Exception $e) {
            throw $e;
        }

    }
    private function executeQueryAll($sql)
    {
        try
        {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    private function useEndereco()
    {
        $sql = 'SELECT cep, logradouro, bairro, cidade, estado FROM base_enderecos_ajax';
        return $sql;
    }
    private function useAgenda()
    {
        $sql = 'SELECT data_agendamento, horario, nome, email, telefone, codigo_medico FROM agenda';
        return $sql;
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
        return $sql;

    }
    private function useFuncionario($nome)
    {
        $sql = $this->createQueryFuncionario();
        $sql .= ' FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo';
        if($nome !== "*")
            $sql .= ' WHERE nome LIKE :nome';
        return $sql;
    }
    private function usePaciente($nome)
    {
        $sql = $this->createQueryPaciente();
        $sql .= ' FROM pessoa INNER JOIN paciente ON pessoa.codigo = paciente.codigo';
        if($nome !== "*")
            $sql .= ' WHERE nome LIKE :nome';
        return $sql;
    }
    private function useMedico($nome)
    {
        $sql = $this->createQueryMedico();
        $sql .= ' FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo
            INNER JOIN medico ON funcionario.codigo = medico.codigo';
        if($nome !== "*")
            $sql .= ' WHERE nome LIKE :nome';
        return $sql;
    }
    private function useMeus(string $nome)
    {
        $sql = "SELECT data_agendamento, horario, agenda.nome, agenda.email, agenda.telefone, pessoa.nome as nome_medico
FROM agenda INNER JOIN pessoa ON agenda.codigo_medico = pessoa.codigo WHERE pessoa.nome LIKE :nome";
        return $sql; 
    }
    public function __construct($db, $tipo)
    {
        $this->db = $db;
        $this->tipo = $tipo;
    }

    public function getData($nome)
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
                break;
            case 'Endereco':
                $sql = $this->useEndereco();
                break;
            case 'Agenda':
                $sql = $this->useAgenda();
                break;
            case 'Meus':
                $sql = $this->useMeus($nome);
                break;
            default:
                return "None";
        }
        try{
            if($this->tipo === 'Endereco' or $this->tipo === 'Agenda')
            {
                $stmt = $this->executeQueryAll($sql);
                return $stmt;   
            }
            else
            {
                $stmt = $this->executeQuery($sql, $nome);
                return $stmt;
            }
        }
        catch (Exception $e) {
            throw $e;
        }
    }

}