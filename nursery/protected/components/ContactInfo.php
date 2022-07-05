<?php

/**
 * Contact information widget
 *
 * @author ftc
 */
class ContactInfo extends CWidget 
{
	public static $CONTACT_INFO_ID = 8;

	public function run() 
	{
        $node = Node::model()->findByPk(ContactInfo::$CONTACT_INFO_ID);
		
        $this->render('contactInfo', array(
        	'node'=>$node)
        );
    }
}
?>
