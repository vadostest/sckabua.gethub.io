<?php


class Submit {
	public function Init ($data=false) {
		$crmStatus = !RETAIL_CRM_USE;
		
		// Имя покупателя
		$userName = isset($data['name']) && !empty($data['name']) ? $data['name'] : 'Не указано';
		// Номер телефона покупателя
		$userPhone = isset($data['phone']) && !empty($data['phone']) ? $data['phone'] : false;
		$email = isset($data['email']) && !empty($data['email']) ? $data['email'] : false;
		// Комментарий покупателя
		$userComment = isset($data['comment']) && !empty($data['comment']) ? $data['comment'] : false;

		$data_ = array(
			'name' => $userName,
			'phone' => $userPhone,	
			'email' => $email,
			'comment' => $userComment ? $userComment : '',
			'orderMethod' => $data['orderMethod'],
			'receiverCity' => $data['receiverCity'],
			'receiverCityRef' => $data['receiverCityRef'],
			'receiverWarehouseRef' => $data['receiverWarehouseRef'],
			'method_delivery' => $data['method_delivery'],

			// Купленный товар
			'item' => array()
		);

		/* RETAIL CRM */
		if (RETAIL_CRM_USE) {
			require 'RetailCrm.php';
			
			$data_["item"] = isset($data['retail_id']) && $data['retail_id'] ? $this->retailCrmData($data_, $data) : array();

            $retailCrm = new retailCrm();
            $crmStatus = $retailCrm->OrdersCreate($data_);
            return $crmStatus;
		}
		
	}

	public function retailCrmData ($data_=false,$data=false) {
		if (!$data || !$data_) return false;

		$_products =  explode(",", $data['retail_id']);
		$_counts =  isset($data['quantity']) && !empty($data['quantity']) ? explode(",", $data['quantity']) : '1';
		$_prices =  isset($data['price']) && !empty($data['price']) ? explode(",", $data['price']) : false;
		$rpt = isset($data['pice_type_id']) && !empty($data['pice_type_id']) ? $data['pice_type_id'] : false;
        $list = array();
		$i=0;

		// Обработка товара с типом цен
		if (count($_products) > 1 && $rpt) {
			$_products_ = array();

            foreach ($_products as $item) {
            	if(!isset($_products_[$item])) $_products_[$item] = 1; else $_products_[$item] = $_products_[$item] + 1;
            }

		    foreach ($_products_ as $k => $item){
		        $list[] =  array(
	                // Число строчным типом без доп. символов
	                // Кол-во купленных единиц товара. Число строчным типом без доп. символов
	                "quantity" =>  $item,
	                // Внешний ID на складе CRM
                    'offer'=> array('externalId' => $k, 'id' => $data['offer_id']),
                    'priceType' => array("code" => $data['pice_type_id'])
		        );
		    }
		} else {
		// Обработка товара без типа цен
			foreach ($_products as $value) {
				array_push($list, array(
					'offer' => array(
						'id' => $data['offer_id'],
						'externalId' => $value
					),
					'quantity' => isset($_counts[$i]) && $_counts[$i] ? $_counts[$i] : '1'
				));

				if (isset($_prices[$i]) && $_prices[$i]) $list[$i]['initialPrice'] = $_prices[$i];

				$i++;
			}
		}

		return $list;
	}
}