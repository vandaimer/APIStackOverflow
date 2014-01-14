<?php
class APIStakOverflow
{
	public function __construct()
	{
		header('Content-Type: text/html; charset=utf-8');
		$this->imprimir();
	}

	/*
	 * Irá obter as questoes usando a API
	 */

	private function getInfoAPI( )
	{
		$url = "https://api.stackexchange.com/2.1/questions?pagesize=3&fromdate=1387843200&order=desc&min=10&sort=votes&tagged=php&site=stackoverflow&filter=!bc0lRWJOQUR*.H";
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url );

		/*
		 * API limit o usa da mesma, por ip, então foi adiciona a seguinte linha
		 * Assim, não chegaria ao limit usando meu ip, fazendo os testes
		 */

		curl_setopt( $curl, CURLOPT_PROXY, '201.59.11.252:3128');
		curl_setopt( $curl, CURLOPT_ENCODING , '' );

		/*
		 * Faz com que a saída retorne, e não seja impresso diretamente como é o default
		 */

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );		
		$retorno =  curl_exec( $curl );
		curl_close( $curl );
		return $retorno;
	}

	public function imprimir(  )
	{

		/*
		 * Decodifica o retorno ( json )
		 */

		$retorno = json_decode( $this->getInfoAPI( ) );

		/*
		 * Itera sobre o objeto, e imprime cada registro
		 */

		foreach( $retorno->items as $item )
		{
			echo "<a href='{$item->owner->link}' target='_blank'>Link Perfil Usuario</a>";
			echo '<br/>';
			echo "<a href='{$item->link}' target='_blank'>Link Questão</a>";
			echo '<br/>';
			echo '-------------------------------------------------------';
			echo '<br/><br/>';
		}
	}
}
new APIStakOverflow();