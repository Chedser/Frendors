<?php ob_start(); ?>

<?php 

session_start();
ini_set('display_errors', 'On');

  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Cache-Control: post-check=0,pre-check=0", false);
  header("Cache-Control: max-age=0", false);
  header("Pragma: no-cache");

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/user_info.php';
$connection_handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/funs.php';

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?php echo str_replace(" ","_",$login); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/media.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;700&display=swap">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<meta name = "description" content = "<?php echo $last_user_status_for_vk;  ?>" />
<meta name="keywords" content = "<?php echo $login; ?>, outmind, crazy, outstanding" / >
<meta name = "author" content = "<?php echo $login; ?>">

<meta property="og:title" content="<?php echo $login; ?>"/>
<meta property="og:description" content="<?php echo $last_user_status_for_vk;  ?>"/>
<meta property="og:image" content="https://frendors.com/users/<?php echo $avatar_for_vk; ?>">


</head>
<body>

<?php echo $topnav_content; ?>

	<div class="user__profile__content">
		<div class="container">
			<div class="user__profile__content__wrapper">
				<div class="user__profile__column">
					<div class="user__profile__info">
						<div class="user__nickname">
							<a ><?php echo $nickname; ?></a>
						</div>
						<div class="user__profile__pseudo">
							<p><?php echo $pseudonick; ?></p>
						</div>
						<div class="user__profile__avatar">
							<img src="<?php echo $avatar; ?>">
						</div>
						<div class="nick__pseudonick">
							<p id="nick"><?php echo str_replace(" ", "_", $body); ?></p>
							<p id="pseudonick"><?php echo $lifestyle; ?></p>
						</div>
						<div class="user__profile__status">
							<p><?php echo $last_user_status; ?></p>
						</div>
						<div class="vodka__value">
							<p> <?php echo "Водка <span id = 'pogons_count_span'>" . $coloner_pogons_count . "</span>";  ?></p>
						</div>
						<?php echo $red_btn; ?>
					</div>
				
					<?php echo $doebat_random; ?>
					<div class="user__profile__friends">
						<p>Долбоебы</p>
						<div class="user__profile__friends__wrapper">
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
							<a href="#"></a>
						</div>
					</div>
				</div>
				<div class="user__profile__actions">
					<div class="add__images">
						<button class="add__images__btn">Вылаживать картинки</button>
					</div>
					<div class="write__history">
						<button class="write__history__btn">Написать историю</button>
					</div>
					<div class="place__history">
						<input type="text" name="" placeholder="Пиши">
						<div class="place__history__block">
							<button class="place__history__btn">Ахуенно</button>
						</div>	
					</div>
					<div class="pagination__wrapper">
						<div class="pagination">
							<a href="#" class="pagination__left__arrows"></a>
							<a href="#" class="pagination__left__arrow"></a>
							<a href="#" class="pagination__number">1</a>
							<a href="#" class="pagination__number">2</a>
							<a href="#" class="pagination__number">3</a>
							<a href="#" class="pagination__right__arrow"></a>
							<a href="#" class="pagination__right__arrows"></a>
						</div>
					</div>
					<div class="user__profile__posts__wrapper">
						<div class="user__post">
							<button class="delete__post">X</button>
							<div class="user__post__header">
								<div class="user__post__info">
									<div class="user__post__avatar">
										<a href="#"></a>
									</div>
									<div class="user__post__username">
										<a href="#">gomerina</a>
									</div>
								</div>
								<div class="user__post__date">
									<p>2 фев 2021 11:43</p>
								</div>
							</div>
							<div class="user__post__text">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
								cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							</div>
							<div class="ahuenno__buttons__section">
								<button class="ahuenno__btn">Ахуенно</button>
								<button class="gavno__btn">Гавно!</button>
							</div>
						</div>
						<div class="user__ahuenno__post">
							<div class="user__ahuenno__post__header">
								<div class="user__ahuenno__info">
									<div class="user__ahuenno__avatar">
										<a href="#"></a>
									</div>
									<div class="ahuenno__username">
										<a href="#">Adminto</a>
									</div>	
								</div>
								<div class="ahuenno__date">
									<p>2 фев 2021 11:43</p>
								</div>
							</div>
							<div class="user__post__ahuenno">
								<span>Ахуенно</span>
								<span class="ahuenno__arrow">&nbsp;</span>
								<a href="#" class="ahuenno__teller__avatar"></a>
								<a href="#" class="ahuenno__teller__nickname">Leo</a>
							</div>
							<div class="user__ahuenno__text">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
								quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
								cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							</div>
							<div class="ahuenno__buttons__section">
								<button class="ahuenno__btn">Ахуенно</button>
								<button class="gavno__btn">Гавно!</button>
							</div>
						</div>
					</div>	
				</div>
				<div class="aside">
					<div class="aside__group">
						<a href="#">Зелёный слоник</a>
						<p>Подписывайся <br> или иди нахуй</p>
					</div>
					<div class="adminto__block">
						<div class="admin__avatar">
							<a href="#"></a>
						</div>
					</div>
				</div>
			</div>	
		</div>	
	</div>
	<div class="images-modal-overlay">
		<div class="images__modal">
			<a class="close-modal">
	  			<svg viewBox="0 0 20 20">
					<path fill="#000000" d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
	  			</svg>
			</a>
			<div class="modal-content">
				<p>Вылаживаем картинку</p>
				<p>Формат: https://pp.userapi.com/c850520/v850520265/8688/sixkEn0Xeao.jpg</p>
				<p>Ссылка</p>
				<input type="text" name="">
				<button class="add__image__btn">Вылаживать</button>
			</div>
  		</div>
	</div>
	<div class="history-modal-overlay">
		<div class="history__modal">
			<a class="close-modal">
	  			<svg viewBox="0 0 20 20">
					<path fill="#000000" d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
	  			</svg>
			</a>
			<div class="modal-content">
				<p class="new__history__title">Новая история</p>
				<p class="blue">Заголовок</p>
				<input type="text" name="">
				<p class="blue">История</p>
				<textarea></textarea>
				<button class="modal__history__btn">Ахуенно</button>
			</div>
  		</div>
	</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/script.js"></script>	
</body>
</html>

<?php ob_end_flush(); ?>