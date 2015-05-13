<?php

namespace Correios;


class XMLRead {
    private $result;


    /**
     * @param $xml
     * @param Correios $correios
     * @return bool
     */
    public function calculateShipping($xml, Correios $correios)
    {
        $xml = simplexml_load_string($xml);

        // total de serviço
        $total = count($xml->Servicos->cServico);

        if ($total > 0) {

            $result = array();

            $i = 0;
            foreach ($xml->Servicos->cServico as $key => $value) {

                $result[$i] = [
                    'codigo' => (string) $value->Codigo,
                    'servico' => (string) $this->codServico["$correios->getCodesService()"],
                    'valor' => (string) $value->Valor,
                    'prazoEntrega' => (string) $value->PrazoEntrega,
                    'valorMaoPropria' => (string) $value->ValorMaoPropria,
                    'valorAvisoRecebimento' => (string) $value->ValorAvisoRecebimento,
                    'valorValorDeclarado' => (string) $value->ValorValorDeclarado,
                    'entregaDomiciliar' => (string) $value->EntregaDomiciliar,
                    'entregaSabado' => (string) $value->EntregaSabado,
                    'erro' => (string) $value->Erro,
                    'msgErro' => (string) $value->MsgErro,
                    'valorSemAdicionais' => (string) $value->ValorSemAdicionais,
                    'obsFim' => (string) $value->ObsFim
                ];
                $i ++;
            }

            $this->result = $result;

            return true;
        }

        $this->result = 'O webservice não retornou nenhum resultado.';
        return false;

    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}