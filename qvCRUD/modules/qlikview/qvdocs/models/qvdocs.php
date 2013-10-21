<?php

namespace app\modules\qlikview\qvdocs\models;

use \XMLReader;

/**
 * This is the model class for table "tbl_qvdocs".
 *
 * @property integer $id
 * @property string $qvDocumentName
 * @property string $qvPath
 * @property string $status
 * @property integer $time_create
 */
class qvdocs extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tbl_qvdocs';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['qvDocumentName', 'required'],
			['time_create', 'integer'],
			['qvDocumentName', 'string', 'max' => 100],
			['qvPath', 'string', 'max' => 180],
			['status', 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'qvDocumentName' => 'Qv Document Name',
			'qvPath' => 'Qv Path',
			'status' => 'Status',
			'time_create' => 'Time Create',
		];
	}

	/**
	 * Will transform the xml file to an assoc array
	 * @param  object $xml XMLReader Object
	 * @return array      an asscoc array of the passed over xml file
	 */
	public static function xml2assoc($xml) {
    $tree = null;
    while($xml->read())
        switch ($xml->nodeType) {
            case XMLReader::END_ELEMENT: return $tree;
            case XMLReader::ELEMENT:
                $node = array('tag' => $xml->name, 'value' => $xml->isEmptyElement ? '' : self::xml2assoc($xml));
                if($xml->hasAttributes)
                    while($xml->moveToNextAttribute())
                        $node['attributes'][$xml->name] = $xml->value;
                $tree[] = $node;
            break;
            case XMLReader::TEXT:
            case XMLReader::CDATA:
                $tree .= $xml->value;
        }
    return $tree;
	}

	/**
	 * Will transform the xml file to an assoc array
	 * @param  object $xml XMLReader Object
	 * @return array      an asscoc array of the passed over xml file
	 */
	public static function xml2assocpf($xml) {
    $tree = null;
    while($xml->read())
        switch ($xml->nodeType) {
            case XMLReader::END_ELEMENT: return $tree;
            case XMLReader::ELEMENT:
                $node = array($xml->name => $xml->isEmptyElement ? '' : self::xml2assocpf($xml));
                if($xml->hasAttributes)
                    while($xml->moveToNextAttribute())
                        $node['attributes'][$xml->name] = $xml->value;
                $tree[] = $node;
            break;
            case XMLReader::TEXT:
            case XMLReader::CDATA:
                $tree .= $xml->value;
        }
    return $tree;
	} 

}
