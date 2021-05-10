<?php
// Получить все продукты с корзины пользователя
function GetAllProductsFromUserCart()
{
	$productIds = array();
	$sum = 0;
	$all_game = array();

	if (empty($_SESSION['id'])) {
		$new_url = '/login';
		header('Location: '.$new_url);
		exit();
	} 
	else {
		//Получение добавленных товаров в корзину
		$productsAtCart = R::getAll( 'select * from cart WHERE id_user  = ?', [$_SESSION['id']] );
		foreach ($productsAtCart as $key) {
			array_push($productIds, $key['id_product']);
		}

		$productsAtCart = R::getAll( 'select * from products WHERE id IN ('.R::genSlots( $productIds ).')', $productIds );

		foreach ($productsAtCart as $product) {
			//Подсчет итого
			$sum = $sum + intval($product["price"]);
			//Получение названия жанра
			$genre = R::findOne('genres', 'id_genre = ?', [$product["id_genre"]]);
			//Получение наименования издателя
			$publisher = R::findOne('publishers', 'id_publisher = ?', [$product["id_publisher"]]);
			//Получение наименования разработчика
			$developer = R::findOne('developers', 'id_developer = ?', [$product["id_developer"]]);
			//Получение наименования сервиса активации
			$activation_service = R::findOne('activation_services', 'id_activation_service = ?', [$product["id_activation_service"]]);
			
			// Вывод всей информации о продукте
			$item = '
			<div class="card mb-3">
			<div class="row g-0">
			<div class="col-md-4">
			<img src="../'.$product["image_name"].'" class="card-img-top">
			</div>
			<div class="col-md-8 bg-dark cart-card-right-border">
			<div class="card-body" style="color: white;">
			<h3 class="card-title">'.$product["name"].'</h3>
			<p class="card-text">Жанр: '.$genre["name"].'</p>
			<p class="card-text">Издатель: '.$publisher["name"].'</p>
			<p class="card-text">Разработчик: '.$developer["name"].'</p>
			<p class="card-text">Сервис активации: '.$activation_service["name"].'</p>
			<span class="card-text text-warning h1">'.$product["price"].' руб.</span>
			<br><br>
			<button class="btn btn-danger" name="deleteFromCartBTN" value="'.$product["id"].'">
			УБРАТЬ ИЗ КОРЗИНЫ
			</button>
			</div>
			</div>
			</div>
			</div>
			';
			array_push($all_game, $item);
		}
		return array("all_game" => $all_game, "sum" => $sum);
	}
	

	$info = GetAllProductsFromUserCart();

	foreach ($info['all_game'] as $game) {
		echo $game;
	}

	echo $info['sum'];
}