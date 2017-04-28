<?php
defined('SYSPATH') or die('No direct script access.');

class Coupon
{

	private static $instances;
	private $data;
	private $site_id;

	public static function & instance($coupon_code = NULL)
	{
		if( ! isset(self::$instances[$coupon_code]))
		{
			$class = __CLASS__;
			self::$instances[$coupon_code] = new $class($coupon_code);
		}
		return self::$instances[$coupon_code];
	}

	public function __construct($coupon_code)
	{
		$this->site_id = Site::instance()->get('id');
		$this->data = NULL;
		$this->_load($coupon_code);
	}

	public function _load($coupon_code)
	{
		if( ! $coupon_code)
		{
			return FALSE;
		}

		$data = array( );
		$result = DB::select()->from('carts_coupons')
			->where('code', '=', $coupon_code)
			->execute()
			->current();

		$this->data = $result;
	}

	public function get($key = NULL)
	{
		if(empty($key))
		{
			return $this->data;
		}
		else
		{
			return isset($this->data[$key]) ? $this->data[$key] : '';
		}
	}

	public function update($coupon_code, $update)
	{
		DB::update('carts_coupons')->set($update)
			->where('code', '=', $coupon_code)
			->execute();
	}

	public function check($amount_product = 0)
	{
		$now = time();
		if($amount_product == 0)
			$amount_product = Cart::product_amount(Session::instance()->get('cart_products'));
		return ($this->get('id')
			&& $this->data['created'] <= $now
			&& $this->data['expired'] >= $now
			&& $this->data['limit'] != 0
			&& $amount_product >= $this->data['condition']
			);
	}

	public function check_error()
	{
		$errno = 0;
		$error = '';

		do
		{
			$valid = $this->check();
			if($valid) break;

			if( ! $this->get('id'))
			{
				$errno = 10;
				$error = 'Sorry that the coupon code you entered is invalid.';
				break;
			}

			$now = time();
			if($this->data['created'] > $now
				|| $this->data['expired'] < $now)
			{
                $lan = LANGUAGE;
                if($lan == 'de'){
                $errno = 1;
                $error ="Es tut uns leid, dass der eingegebeneGutscheincode abgelaufen ist.";               
                }elseif($lan == 'es'){
                $errno = 1;
                $error ="Lo siento, el código que has introducido ha expirado.";            
                }elseif($lan == 'fr'){
                $errno = 1;
                $error ="Désolé que le code de coupon que vous avez entré a expiré.";                       
                }elseif($lan === 'ru'){
                $errno = 1;
                $error ="Жаль, что введенный код купона истек.";                        
                }else{
                $errno = 1;
                $error = 'Sorry that the coupon code you entered has expired.';             
                }
				break;
			}

			if($this->data['limit'] == 0)
			{
				$lan = LANGUAGE;
				if($lan == 'de'){
				$errno = 2;
				$error ="Es tut uns leid,dass der eingegebene Gutscheincode verwendet wurde.";				
				}elseif($lan == 'es'){
				$errno = 2;
				$error ="Lo siento, el cupón ha sido utilizado.";						
				}elseif($lan == 'fr'){
				$errno = 2;
				$error ="Désolé que le code promo vous avez entré a été utilisé.";						
				}elseif($lan == 'ru'){
				$errno = 2;
				$error ="Жаль, что введенный код купона уже был использован.";						
				}else{
				$errno = 2;
				$error = 'Sorry that the coupon code you entered has been used.';				
				}

				
				break;
			}

			$amount_product =
				Cart::product_amount(Session::instance()->get('cart_products'));
			if($this->data['condition'] > $amount_product)
			{
				$lan = LANGUAGE;

				if($lan === 'de'){
				$errno = 3;
				$error ="Es tut uns leid, dass die Zwischensumme in Ihr Warenkorb über \${$this->data['condition']} sein muss, wenn Sie diesen Gutschein-Code verwenden möchten.";				
				}elseif($lan === 'es'){
				$errno = 3;
				$error ="Lo sentimos que el subtotal debe ser mayor de {$this->data['condition']} dólares para utilizar el código de descuento.";						
				}elseif($lan === 'fr'){
				$errno = 3;
				$error ="Désolé, le montant total doit être supérieur à {$this->data['condition']}$ si vous voulez utilisez ce code.";						
				}elseif($lan === 'ru'){
				$errno = 3;
				$error ="Извините, вы не можете использовать этот код купон с заказом ниже {$this->data['condition']} долларов.";						
				}else{
				$errno = 3;
				$error = "Sorry that to use the coupon code your cart subtotal must be over \${$this->data['condition']}.";					
				}
			}
		}
		while( false );

		return array( $errno, $error );
	}

	public function save($price)
	{
		$save = 0.0;
		if($this->data['catalog_limit'] || $this->data['product_limit'])
		{
			$effective_id = array( );
			if($this->data['product_limit'])
			{
				$effective_id = array_merge($effective_id, explode(',', $this->data['product_limit']));
			}

			if($this->data['catalog_limit'])
			{
				foreach( explode(',', $this->data['catalog_limit']) as $cid )
				{
					$catalog = Catalog::instance($cid);
					if($catalog->get('id'))
					{
						$effective_id = array_merge($effective_id, $catalog->products());
					}
				}
			}

			$products = Session::instance()->get('cart_products', array( ));
			$effective_limit = intval($this->data['effective_limit']);
			foreach( $products as $product )
			{
				// if($this->data['target'] != 'global')
				if($this->data['target'] != 1)
                {
	                $discount_price = Product::instance($product['id'])->price();
	                $product_price = round(Product::instance($product['id'])->get('price'),2);
	                if ($discount_price < $product_price) continue;
            	}

				if( ! in_array($product['id'], $effective_id)) continue;

				if($effective_limit != -1 && $effective_limit <= 0) break;

				switch( $this->data['type'] )
				{
					case 1:
						if($effective_limit == -1)
						{
							$save += (($product['price'] * $this->data['value']) / 100) * $product['quantity'];
						}
						else if($effective_limit >= $product['quantity'])
						{
							$save += (($product['price'] * $this->data['value']) / 100) * $product['quantity'];
							$effective_limit -= $product['quantity'];
						}
						else
						{
							$save += (($product['price'] * $this->data['value']) / 100) * $effective_limit;
							$effective_limit = 0;
						}
						break;
					case 2:
						if($effective_limit == -1)
						{
							$save = (min($product['price'], $this->data['value']));
						}
						else if($effective_limit >= $product['quantity'])
						{
							$save = (min($product['price'], $this->data['value']));
							$effective_limit -= $product['quantity'];
						}
						else
						{
							$save = (min($product['price'], $this->data['value']));
							$effective_limit = 0;
						}
						break;
					case 4:
						if($effective_limit == -1)
						{
							$save += ($product['price'] - $this->data['value']) * $product['quantity'];
						}
						else if($effective_limit >= $product['quantity'])
						{
							$save += ($product['price'] - $this->data['value']) * $product['quantity'];
							$effective_limit -= $product['quantity'];
						}
						else
						{
							$save += ($product['price'] - $this->data['value']) * $effective_limit;
							$effective_limit = 0;
						}
						break;
				}
			}
		}
		else
		{
				// if($this->data['target'] != 'global')
				if($this->data['target'] != 1)
				{
			            $products = Session::instance()->get('cart_products', array());
			            foreach ($products as $product)
			            {
			                    $discount_price = Product::instance($product['id'])->price();
			                    $product_price = round(Product::instance($product['id'])->get('price'), 2);
			                    $promotion_coupon = Site::instance()->get('promotion_coupon');
			                    if(!$promotion_coupon)
			                    {
			                            if ($discount_price < $product_price)
			                            {
			                                    $price = $price - $discount_price * $product['quantity'];
			                            }
			                    }
			            }
				}

		        switch ($this->data['type'])
		        {
		                case '1':
		                        $save = ($price * $this->data['value']) / 100;
		                        break;
		                case '2':
		                        $save = min($price, $this->data['value']);
		                        break;
		        }
        }

		return number_format($save, 2);
	}

	public function apply()
	{
		if($this->check())
		{
			$this->used_inc(1);
			if($this->data['limit'] > 0)
			{
				$this->limit_dec(1);
			}

			$this->_load($this->get('code'));
		}
	}

	public function limit_dec($amount)
	{
		$amount = intval($amount);
		return DB::query(Database::UPDATE, "UPDATE carts_coupons SET `limit` = `limit` - $amount WHERE id=".$this->get('id'))
				->execute();
	}

	public function used_inc($amount)
	{
		$amount = intval($amount);
		return DB::query(Database::UPDATE, "UPDATE carts_coupons SET `used` = `used` + $amount WHERE id=".$this->get('id'))
				->execute();
	}

	public function add($data)
	{
		$coupon = ORM::factory('coupon');
		$coupon->site_id = $data['site_id'];
		$coupon->code = Arr::get($data, 'code', '');
		$coupon->value = Arr::get($data, 'value', '');
		$coupon->type = Arr::get($data, 'type', '');
		$coupon->limit = Arr::get($data, 'limit', '');
		$coupon->created = Arr::get($data, 'created', '');
		$coupon->expired = Arr::get($data, 'expired', '');
		$coupon->condition = Arr::get($data, 'condition', '');
		$coupon->catalog_limit = Arr::get($data, 'catalog_limit', '');
		$coupon->product_limit = Arr::get($data, 'product_limit', '');
		$coupon->effective_limit = Arr::get($data, 'effective_limit', '-1');
		$coupon->item_sku = Arr::get($data, 'item_sku', '');
        $coupon->admin = Arr::get($data, 'admin', '');
        $coupon->on_show = Arr::get($data, 'on_show', '');
        $coupon->usedfor = Arr::get($data, 'coupon_set', '');
        $coupon->target = Arr::get($data, 'target', NULL);
		$coupon->save();

		if($coupon->saved() == TRUE)
		{
			return $coupon->id;
		}
		else
		{
			return FALSE;
		}
	}

	public function create()
	{
		$create_code = str_pad('A'.time().rand(0, 999), 15, '0');
		$rs = $this->_load($create_code);

		if($rs == false)
		{
			return $create_code;
		}
		else
		{
			return $this->create();
		}
	}

}
