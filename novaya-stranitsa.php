<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"",
	Array(
		"EMAIL_TO" => "emurzaeva636@gmail.com",
		"EVENT_MESSAGE_ID" => array(),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array("EMAIL"),
		"USE_CAPTCHA" => "Y"
	)
);
$connection = Bitrix\Main\Application::getConnection();
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$connection->queryExecute("INSERT INTO comments (COMMENT) VALUES ('".$request->get('MESSAGE')."')");
   

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>