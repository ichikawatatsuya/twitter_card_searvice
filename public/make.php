<?php
if (empty($_POST)
	|| empty($_POST['text'])
	|| 100 < mb_strlen($_POST['text'])
)
{
	header('HTTP', true, 400);
	echo 'Bad Request';
	exit;
}

try
{
	// 真っ白な1200x530の画像作成
	$canvas = new \Imagick();
	$canvas->newImage(1200, 630, '#fff', 'png');

	// テキストを作成
	$t = new \ImagickDraw();

	// 日本語を使いたい場合は別途ダウンロードして下の1行のように指定してください
	// $t->setFont('path/to/japanese_font.ttf');
	$t->setFontSize(60);
	$t->setGravity(\Imagick::GRAVITY_CENTER);
	$t->annotation(0, 0, $_POST['text']);

	// テキストを重ねて出力
	$canvas->drawImage($t);

	// 画像表示
	header("Content-Type: image/png");
	echo $canvas->getImageBlob();
}
catch (\Throwable $e)
{
	header('HTTP', true, 500);
	echo 'Internal Server Error';
	exit;
}
