<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);
	$file = $_FILES['file'];

	//От кого письмо
	$mail->setFrom('email@example.com', 'Формы обратной связи от Московской Городской Службы Недвижимости');
	//Кому отправить
	$mail->addAddress('email@example.com');
	// $mail->addAddress('lapinnipal@icloud.com');
	//Тема письма
	$mail->Subject = 'Формы обратной связи';

	//Тело письма
	$body = '<h1>Формы обратной связи от Московской Городской Службы Недвижимости</h1>';

	if(trim(!empty($_POST['type-form']))){
		$body.='<p><strong>С какой формы заявка:</strong> '.$_POST['type-form'].'</p>';
	}	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	}
	if(trim(!empty($_POST['tel']))){
		$body.='<p><strong>Телефон:</strong> '.$_POST['tel'].'</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>Email:</strong> '.$_POST['email'].'</p>';
	}
	if(trim(!empty($_POST['textarea']))){
		$body.='<p><strong>Текст сообщения:</strong> '.$_POST['textarea'].'</p>';
	}
	if(trim(!empty($_POST['street']))){
		$body.='<p><strong>Улица:</strong> '.$_POST['street'].'</p>';
	}
	if(trim(!empty($_POST['house']))){
		$body.='<p><strong>Дом:</strong> '.$_POST['house'].'</p>';
	}
	if(trim(!empty($_POST['floor']))){
		$body.='<p><strong>Этаж:</strong> '.$_POST['floor'].'</p>';
	}
	if(trim(!empty($_POST['square']))){
		$body.='<p><strong>Площадь:</strong> '.$_POST['square'].'</p>';
	}
	if(trim(!empty($_POST['price']))){
		$body.='<p><strong>Стоимость:</strong> '.$_POST['price'].'</p>';
	}
	if(trim(!empty($_POST['repair']))){
		$body.='<p><strong>Состояние квартиры:</strong> '.$_POST['repair'].'</p>';
	}
	if(trim(!empty($_POST['form-contact']))){
		$body.='<p><strong>Способ связи:</strong> '.$_POST['form-contact'].'</p>';
	}
	if(trim(!empty($_POST['time']))){
		$body.='<p><strong>Когда связятся:</strong> '.$_POST['time'].'</p>';
	}
	if(trim(!empty($_POST['group']))){
		$body.='<p><strong>Обьект продажи:</strong> '.$_POST['group'].'</p>';
	}


	foreach ( $_POST as $key => $value ) {
		if (empty($_POST['name']) && empty($_POST['type-form'])) {
			$body .= "
			<p><strong>$key:</strong> $value</p>		
		";
		}
			
	}

	  // Прикрипление файлов к письму
	  if (!empty($file['name'][0])) {
		for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
		  $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
		  $filename = $file['name'][$ct];
		  if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
			  $mail->addAttachment($uploadfile, $filename);
			  $rfile[] = "Файл $filename прикреплён";
		  } else {
			  $rfile[] = "Не удалось прикрепить файл $filename";
		  }
		}
	  }

	
	/*
	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/sendmail/attachments/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Фото в приложении</strong>';
			$mail->addAttachment($fileAttach);
		}
	}
	*/

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Данные отправлены! УРА';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>