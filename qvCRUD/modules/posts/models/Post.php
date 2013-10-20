<?php

namespace app\modules\posts\models;

use Yii;

use app\models\User;
use app\modules\workflow\models\Workflow;
use app\modules\comments\models\Comment;
use app\modules\tags\models\Tag;

/**
 * This is the model class for table "tbl_post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property string $status
 * @property integer $author_id
 * @property integer $time_create
 * @property integer $time_update
 *
 * @property  $author
 */
class Post extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tbl_post';
	}

	private $_oldTags;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status', 'required'),
			array('status', 'in', 'range'=>array(Workflow::STATUS_DRAFT,Workflow::STATUS_PUBLISHED,Workflow::STATUS_ARCHIVED)),
			array('title', 'string', 'max'=>128),
			array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),

			//array('title, status', 'safe', 'on'=>'search'),
		);
	}


	public function getComments() {
		return $this->hasMany('\app\modules\comments\models\Comment', array('comment_id' => 'id')) //
		            ->where('status = "'. Workflow::STATUS_APPROVED.'" AND comment_table = '.Workflow::MODULE_BLOG)
					->orderBy('time_create DESC');
	}

	
	public function getAuthor() {
		return $this->hasOne('User', array('id' => 'author_id'));
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'          => 'Id',
			'title'       => Yii::t('app','Title'),
			'content'     => Yii::t('app','Content'),
			'tags'        => Yii::t('app','Tags'),
			'status'      => Yii::t('app','Status'),
			'time_create' => Yii::t('app','Create Time'),
			'time_update' => Yii::t('app','Update Time'),
			'author_id'   => Yii::t('app','Author'),
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::$app->controller->createUrl('post/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=Html::a(Html::encode($tag), array('post/index', 'tag'=>$tag), array('class'=>'label'));
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		if(Yii::$app->params['commentNeedApproval'])
			$comment->status=Workflow::STATUS_DRAFT;
		else
			$comment->status=Workflow::STATUS_APPROVED;
		$comment->comment_table=Workflow::MODULE_BLOG;
		$comment->comment_id=$this->id;
		return $comment->save();
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	public function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert) {
				$this->time_create=$this->time_update=time();
				$this->author_id=Yii::$app->user->identity->id;
			}
			else {
				$this->time_update=time();
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This is invoked after the record is saved.
	 */
	public function afterSave($insert)
	{
		parent::afterSave($insert);
		Tag::updateFrequency($this->_oldTags, $this->tags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	public function afterDelete()
	{
		if (parent::beforeDelete()) {
			Comment::deleteAll('comment_id='.$this->id.' AND comment_table="'.Workflow::MODULE_BLOG.'"');
			Tag::updateFrequency($this->tags, '');
		} else {
			return false;
		}
	}

	/**
	 * This will return the query the passed number of posts ordered desc by time created
	 * 
	 * @param  limit number of records to be listed by data provider
	 * @return  query containing the correct sql for active data provider
	 */
	
	public static function getAdapterForPosts($limit=5,$tag='All')
	{
		return static::find()->where('status="'.Workflow::STATUS_PUBLISHED.'" AND tags LIKE "%'.$tag.'%"')
					->orderBy('time_create DESC')
					->limit($limit);
	}

}
