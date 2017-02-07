<?php
require_once("_header.php");
# ��������� � ��������� ������ �����
if (count($_POST) > 0) {
	$response = $wmxi->X5(
		intval($_POST["wmtranid"]),    # ����� ����� ��� �����
		trim($_POST["pcode"])          # ������������ ������ �� 1 �� 255 ��������; ������� � ������ ��� ����� �� �����������
	);
	# ��������������� ����� ������� � ���������. ������� ���������:
	# - XML-����� �������
	# - ���������, ������������ �� �����. �� ��������� ������������ UTF-8
	$structure = $parser->Parse($response, DOC_ENCODING);
	# ����������� ������� ��������� � ����� ������� ��� �������.
	# �� ������������� ��������� ����� �������������� � � �����������, ���� �� ��������
	# ��������� ���������� ����� (��������, ������ ����������)
	# ���� ���������� � ���������� XML-����� ������ ���, �� ������ �������� �����
	# ���������� � false - � ����� ������ ��������� ������ ����� ����������
	$transformed = $parser->Reindex($structure, true);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<title>X5</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?= DOC_ENCODING; ?>"/>
	<meta name="author" content="DKameleon"/>
	<meta name="site" content="http://my-tools.net/wmxi/"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
��������� �������� ����������:
<a href="http://webmoney.ru/rus/developers/interfaces/xml/codeprotect/index.shtml">http://webmoney.ru/rus/developers/interfaces/xml/codeprotect/index.shtml</a>
<br/>

<form action="" method="post">

	<label>���������� ����� ������� � ������� ����� WebMoney:</label>
	<input type="text" name="wmtranid" value="0"/>
	<br/>

	<label>��� ��������� ������:</label>
	<input type="text" name="pcode" value="0"/>
	<br/>

	<input type="submit" value="������ ���"/>
	<br/>

</form>

<!--pre><?= htmlspecialchars(@$response, ENT_QUOTES); ?></pre-->
<!--pre><?= htmlspecialchars(print_r(@$structure, true), ENT_QUOTES); ?></pre-->
<!--pre><?= htmlspecialchars(print_r(@$transformed, true), ENT_QUOTES); ?></pre-->

<pre><!-- ������ � ���������� �������� ������������� ������� ����� ��������� ������ � ������� -->
		��� �������: <b><?= htmlspecialchars(@$transformed["w3s.response"]["operation"]["opertype"], ENT_QUOTES); ?></b>
		�������: <b><?= htmlspecialchars(@$transformed["w3s.response"]["operation"]["dateupd"], ENT_QUOTES); ?></b>

		��� ������: <b><?= htmlspecialchars(@$transformed["w3s.response"]["retval"], ENT_QUOTES); ?></b>
		�������� ������: <b><?= htmlspecialchars(@$transformed["w3s.response"]["retdesc"], ENT_QUOTES); ?></b>
	</pre>

</body>
</html>
