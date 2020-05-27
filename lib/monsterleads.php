<?php
	use \Curl\Curl;

	class MonsterleadsApi {
		public function Init ($data=false) {
			if (!$data) return false;

			$curl = new Curl();
			$curl->setHeader('X-Requested-With', 'XMLHttpRequest');
			$curl->setReferrer($_SERVER['HTTP_REFERER']);
			$curl->setUserAgent($_SERVER['HTTP_USER_AGENT']);

			$curl->post(MONSTERLEADS_URL.'/method/order.add?api_key='.MONSTERLEADS_API_KEY.'&format=json', $data);

			if ($curl->error) {
			    echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
			    return false;
			} else {
			    return true;
			}
		}
	}
?>