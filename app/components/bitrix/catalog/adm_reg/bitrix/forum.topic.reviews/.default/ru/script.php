<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript">
if (typeof oErrors != "object")
	var oErrors = {};

oErrors['no_topic_name'] = "<?=CUtil::addslashes(GetMessage("JERROR_NO_TOPIC_NAME"))?>";
oErrors['no_message'] = "<?=CUtil::addslashes(GetMessage("JERROR_NO_MESSAGE"))?>";
oErrors['max_len1'] = "<?=CUtil::addslashes(GetMessage("JERROR_MAX_LEN1"))?>";
oErrors['max_len2'] = "<?=CUtil::addslashes(GetMessage("JERROR_MAX_LEN2"))?>";
oErrors['no_url'] = "<?=CUtil::addslashes(GetMessage("FORUM_ERROR_NO_URL"))?>";
oErrors['no_title'] = "<?=CUtil::addslashes(GetMessage("FORUM_ERROR_NO_TITLE"))?>";


if (typeof oText != "object")
	var oText = {};

oText['author'] = " <?=CUtil::addslashes(GetMessage("JQOUTE_AUTHOR_WRITES"))?>:\n";
oText['translit_en'] = "Ru->En";
oText['enter_url'] = "<?=CUtil::addslashes(GetMessage("FORUM_TEXT_ENTER_URL"))?>";
oText['enter_url_name'] = "<?=CUtil::addslashes(GetMessage("FORUM_TEXT_ENTER_URL_NAME"))?>";
oText['enter_image'] = "<?=CUtil::addslashes(GetMessage("FORUM_TEXT_ENTER_IMAGE"))?>";
oText['list_prompt'] = "<?=CUtil::addslashes(GetMessage("FORUM_LIST_PROMPT"))?>";


if (typeof oHelp != "object")
	var oHelp = {};

oHelp['B'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_BOLD"))?>";
oHelp['I'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_ITALIC"))?>";
oHelp['U'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_UNDER"))?>";
oHelp['FONT'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_FONT"))?>";
oHelp['COLOR'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_COLOR"))?>";
oHelp['CLOSE'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_CLOSE"))?>";
oHelp['URL'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_URL"))?>";
oHelp['IMG'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_IMG"))?>";
oHelp['QUOTE'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_QUOTE"))?>";
oHelp['LIST'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_LIST"))?>";
oHelp['CODE'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_CODE"))?>";
oHelp['CLOSE_CLICK'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_CLICK_CLOSE"))?>";
oHelp['TRANSLIT'] = "<?=CUtil::addslashes(GetMessage("FORUM_HELP_TRANSLIT"))?>";

function reply2author(name)
{
	<?if ($arResult["FORUM"]["ALLOW_QUOTE"] == "Y"):?>
	document.REPLIER.REVIEW_TEXT.value += "[b]"+name+"[/b]"+" \n";
	<?else:?>
	document.REPLIER.REVIEW_TEXT.value += name+" \n";
	<?endif;?>
	return false;
}
<?if ($arResult["LANGUAGE_ID"]=="ru"):?>
var smallEngLettersReg = new Array(/e'/g, /ch/g, /sh/g, /yo/g, /jo/g, /zh/g, /yu/g, /ju/g, /ya/g, /ja/g, /a/g, /b/g, /v/g, /g/g, /d/g, /e/g, /z/g, /i/g, /j/g, /k/g, /l/g, /m/g, /n/g, /o/g, /p/g, /r/g, /s/g, /t/g, /u/g, /f/g, /h/g, /c/g, /w/g, /~/g, /y/g, /'/g);
var smallRusLetters = new Array("э", "ч", "ш", "ё", "ё", "ж", "ю", "ю", "я", "я", "а", "б", "в", "г", "д", "е", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "щ", "ъ", "ы", "ь");

var capitEngLettersReg = new Array(
	/Ch/g, /Sh/g, 
	/Yo/g, /Zh/g, 
	/Yu/g, /Ya/g, 
	/E'/g, /CH/g, /SH/g, /YO/g, /JO/g, /ZH/g, /YU/g, /JU/g, /YA/g, /JA/g, /A/g, /B/g, /V/g, /G/g, /D/g, /E/g, /Z/g, /I/g, /J/g, /K/g, /L/g, /M/g, /N/g, /O/g, /P/g, /R/g, /S/g, /T/g, /U/g, /F/g, /H/g, /C/g, /W/g, /Y/g);
var capitRusLetters = new Array(
	"Ч", "Ш",
	"Ё", "Ж",
	"Ю", "Я",
	"Э", "Ч", "Ш", "Ё", "Ё", "Ж", "Ю", "Ю", "\Я", "\Я", "А", "Б", "В", "Г", "Д", "Е", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Щ", "Ы");

var smallRusLettersReg = new Array(/э/g, /ч/g, /ш/g, /ё/g, /ё/g,/ж/g, /ю/g, /ю/g, /я/g, /я/g, /а/g, /б/g, /в/g, /г/g, /д/g, /е/g, /з/g, /и/g, /й/g, /к/g, /л/g, /м/g, /н/g, /о/g, /п/g, /р/g, /с/g, /т/g, /у/g, /ф/g, /х/g, /ц/g, /щ/g, /ъ/g, /ы/g, /ь/g );
var smallEngLetters = new Array("e", "ch", "sh", "yo", "jo", "zh", "yu", "ju", "ya", "ja", "a", "b", "v", "g", "d", "e", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h", "c", "w", "~", "y", "'");

var capitRusLettersReg = new Array(
	/Ч(?=[^А-Я])/g, /Ш(?=[^А-Я])/g, 
	/Ё(?=[^А-Я])/g, /Ж(?=[^А-Я])/g, 
	/Ю(?=[^А-Я])/g, /Я(?=[^А-Я])/g, 
	/Э/g, /Ч/g, /Ш/g, /Ё/g, /Ё/g, /Ж/g, /Ю/g, /Ю/g, /Я/g, /Я/g, /А/g, /Б/g, /В/g, /Г/g, /Д/g, /Е/g, /З/g, /И/g, /Й/g, /К/g, /Л/g, /М/g, /Н/g, /О/g, /П/g, /Р/g, /С/g, /Т/g, /У/g, /Ф/g, /Х/g, /Ц/g, /Щ/g, /Ъ/g, /Ы/g, /Ь/g);
var capitEngLetters = new Array(
	"Ch", "Sh",
	"Yo", "Zh",
	"Yu", "Ya",
	"E", "CH", "SH", "YO", "JO", "ZH", "YU", "JU", "YA", "JA", "A", "B", "V", "G", "D", "E", "Z", "I", "J", "K", "L", "M", "N", "O", "P", "R", "S", "T", "U", "F", "H", "C", "W", "~", "Y", "'");
<?endif;?>
</script>