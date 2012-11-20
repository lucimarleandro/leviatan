<?php
class UtilsHelper extends AppHelper {
	
/**
 * Mostrar a data completa
 *
 * @param integer $dataHora Data e hora em timestamp ou null para atual
 * @return string Descrição da data no estilo "Sexta-feira", 01 de Janeiro de 2010"
 * @access public
 */
	function full_date($date = null) {
		//	$_diasDaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
		$_meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
	
		$date = $this->data_sets($date);
		$w = date('w', $date);
		$n = date('n', $date) - 1;
	
		return sprintf('João Pessoa, %02d de %s de %04d', date('d', $date), $_meses[$n], date('Y', $date));
	}
	
/**
 * Se a data for nula, usa data atual
 *
 * @param mixed $data
 * @return integer Se null, retorna a data/hora atual
 * @access protected
 */
	function data_sets($data) {
		if (is_null($data)) {
			return time();
		}
		if (is_integer($data) || ctype_digit($data)) {
			return (int)$data;
		}
		return strtotime((string)$data);
	}
	
}