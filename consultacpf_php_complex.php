<?php
	
	/*
	 *  Acessando WebService ConsultaCPF.com para realizar consultas na SERASA
	 *  Author: Gustavo Gatto (inbox@gustavogatto.net / twitter: gustavogatto)
	 *  Requires: SimpleXML, SOAP Libraries
	**/
	
	# Caching Control
	header("Content-Type: text/html; charset=utf-8", true);
	header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: pre-check=0, post-check=0, max-age=0');
    header("Pragma: no-cache");
	
	# Authentication
sEml = "seu login aqui";
sPwd = "senha aqui";
sDoc = $_POST['cpf']; // CPF ou CNPJ
	
	try {
		
		#wsdl  ="http://www.consultacpf.com/webservices/producao/consultacpf.asmx?WSDL"; # (PRODUCTION)
wsdl   = "http://www.consultacpf.com/webservices/test-drive/consultacpf.asmx?WSDL"; # (TEST DRIVE)
result = "";
occur  = array();
		
		/* CONSULTAS DISPONÍVEIS:
		 * - ConsultaChequeSERASA
		 * - ConsultaConcentreSERASA
		 * - ConsultaDetalhadaSERASA
		 * - ConsultaHistorico
		 * - ConsultaHistoricoPorToken
		 * - ConsultaSaldoCliente
		 * - ConsultaSimplesSERASA
		 * - ConsultaSinteseCadastralSERASA
		 * - ConsultaSinteseEmpresarialSERASA 
        **/
svce = $_POST['tipoconsulta']; 
		
soap = new SoapClient($wsdl);
vEml = new SoapVar($sEml, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
vPwd = new SoapVar($sPwd, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
vDoc = new SoapVar($sDoc, XSD_STRING, "string", "http://www.w3.org/2001/XMLSchema");
		
wrap->EMail     = $vEml;
wrap->Senha     = $vPwd;
wrap->Documento = $vDoc;
		
param = new SoapParam($wrap, "tns:" . $svce);
		eval('$result = ($soap->__soapCall($svce, array($param))->'.svce .'Result);');
		
xml = @$result->Pendencias->any;
		if (strlen($xml)) {
occur = simplexml_load_string($xml);
			if (@$occur->NewDataSet) {
occur = $occur->NewDataSet;
			} elseif (($svce == "ConsultaConcentreSERASA") && (@$occur->PendenciasConcentre)) {
occur = $occur->PendenciasConcentre;
			}
		}
		
		# Print Object Result
		#print_r($result);
		
		# Sample Get Item Result
		echo '<br /><br />Resultados: <br>Nome: '.result->Nome . '<br />Documento: '. $result->Documento .'<br />Nome da Mae: '. $result->NomeMae .'<br/> Data de nascimento: '. $result->DataNasc .'<br />Situa&ccedil;&atilde;o: '. $result->SituacaoDocumento .'<br />Total de Ocorrencias: '. $result->TotalOcorrencias .'<br />';
		
		# Print Occurrences Lists
		#print_r($occur);
		
		# Sample List Items Occurrences
		if ($occur) {
		foreach (@$occur->Grafias asitem) {
			echo '<br /><br />Sample List Item: '.item->Grafia;
		}
		}
	} catch(SoapFaulte) {
		trigger_error('#Error.SOAPFault: '.$e->faultstring, E_USER_WARNING);
	}
	
?>
