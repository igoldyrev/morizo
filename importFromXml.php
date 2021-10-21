    <?php
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
CModule::IncludeModule("iblock");

function CustomMorizoTestTaskEvent($count)
{
	define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
	AddMessage2Log("В инфоблок добавлено " . $count . "записей");
}

$type='typeblock';
$SORT=500;

$ib = new CIBlock;

$arFields = Array(
  "ACTIVE" => 'Y',
  "NAME" => 'customMorizoTestBlock',
  "CODE" => 'customMorizoTestBlock',
  "IBLOCK_TYPE_ID" => $type,
  "SITE_ID" => 's1',
  "SORT" => $SORT,
  "DESCRIPTION_TYPE" => 'text',
);

$ib->Add($arFields);

if(CModule::IncludeModule("iblock") && ($arIBlock = GetIBlock($_GET["BID"], "customMorizoTestBlock")))
{
	$reader = new XMLReader();
    $doc = new DOMDocument;
    $count = 0;

    // сам файл выложен по ссылке https://yadi.sk/d/irqGHS4X170kog из-за ограничений гитхаб

    $reader->open('example.xml'); // указываем ридеру что будем парсить этот файл

    while($reader->read()) {

    	$el = new CIBlockElement;

        if($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'test') {

        	$node = simplexml_import_dom($doc->importNode($reader->expand(), true));

            $data = array();

            $name = $node->name;
            $description = $node->description;

            $reader->read();

            if($reader->nodeType == XMLReader::TEXT) {

                $data['name'] = $reader->value;

            }

            $arLoadProductArray = Array(
  			"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
  			"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
  			"IBLOCK_ID"      => $arIBlock,
  			"NAME"           => "Элемент",
  			"ACTIVE"         => "Y",            // активен
  			 "PROPERTY_VALUES" => array(
   				"NAME" => $name,
   				"DESCRIPTION" => $age,
   				)
  			);

            $el->Add($arLoadProductArray);
            $count++;

        }
    }

    CustomMorizoTestTaskEvent($count);
}
