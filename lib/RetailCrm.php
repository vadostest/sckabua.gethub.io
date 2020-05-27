<?php

class retailCrm {
	
	public function OrdersCreate($data=false) {
		if ($data) {
		    $client = new \RetailCrm\ApiClient(RETAIL_CRM_URL, RETAIL_CRM_API_KEY, \RetailCrm\ApiClient::V5);

		    $data_ = array(
		    	'site' => array(
					'name' => SITE_NAME,
					'url' => SITE_URL,
				),
				'orderMethod' => $data['orderMethod'],
				// 'customFields' => array(
				// 	'ref' => $data['referal'],
				// 	'svyaz' => $data['method_call'],
				// ),
				'delivery' => array(
					'code' => $data['method_delivery'],
					'data' => array(
						'receiverCity' => $data['receiverCity'],
						'receiverCityRef' => $data['receiverCityRef'],
						'pickuppointId' => $data['receiverWarehouseRef'],
						'paymentForm' => 'Cash'
					),
				),
				'items' => $data['item'],
				'source' => array(
			        'source' => $_SESSION['utms']['utm_source'],
			        'medium' => $_SESSION['utms']['utm_medium'],
			        'campaign' => $_SESSION['utms']['utm_campaign'],
			        'keyword' => $_SESSION['utms']['utm_term'],
			        'content' => $_SESSION['utms']['utm_content'],
		      	)
		    );

		    if (isset($data['name']) && $data['name']) $data_['firstName'] = $data['name'];
		    if (isset($data['phone']) && $data['phone']) $data_['phone'] = $data['phone'];
		    if (isset($data['email']) && $data['email']) $data_['email'] = $data['email'];
		    if (isset($data['comment']) && $data['comment']) $data_['customerComment'] = $data['comment'];

			$user_id = $this->getUserIdByPhone($data['phone']);

			if(!empty($data['discount'])) {
				$data_['discount'] = $data['discount'];
				// $data_['customFields']['min_offers'] = $data['discount']; 
			} else {
				if($data['discountPercent']) {
					$data_['discountPercent'] = '10';
				}
			}
			
			if(!empty($user_id)) {
				$data_['customer']['id'] = $user_id;
				$user_find = $this->getUserById($user_id);

				if($user_find['cumulativeDiscount']) {
					if($data_['discountPercent']) {
						$data_['discountPercent'] = intval($data_['discountPercent']) + intval($user_find['cumulativeDiscount']);
					} else {
						$data_['discountPercent'] = intval($user_find['cumulativeDiscount']);
					}
				}
			}
			
			try {
		        $externalId = 'o-create-' . time();
			    $response = $client->request->ordersCreate($data_);
			} catch (\RetailCrm\Exception\CurlException $e) {
			    echo "Connection error: " . $e->getMessage();
			}

			if ($response->isSuccessful() && 201 === $response->getStatusCode()) {
			    return $response->id;
			} else {
				print_r($response);
			    echo sprintf(
			        "Error: [HTTP-code %s] %s",
			        $response->getStatusCode(),
			        $response->getErrorMsg()
			    );
			}
		} else return false;
	}

	public function getUserIdByPhone($phone) {
		$user_id = '';
	    $client = new \RetailCrm\ApiClient(RETAIL_CRM_URL, RETAIL_CRM_API_KEY, \RetailCrm\ApiClient::V5);
		$response = $client->request->customersList(array(
			'name' => $phone
		));
		$user_id = $response['customers'][0]['id'];
		return $user_id;
	}
  
  
	public function getUserById($user_id) {
	    $client = new \RetailCrm\ApiClient(RETAIL_CRM_URL, RETAIL_CRM_API_KEY, \RetailCrm\ApiClient::V5);
		$response = $client->request->customersList(array(
			'ids' => array($user_id)
		));

		return $response['customers'][0];
	}
}