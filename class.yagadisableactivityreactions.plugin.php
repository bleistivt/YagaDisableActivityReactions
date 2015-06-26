<?php

$PluginInfo['YagaDisableActivityReactions'] = array(
    'Name' => 'Yaga Disable Activity Reactions',
    'Description' => 'Turns off reactions for activities.',
    'Version' => '0.3',
    'RequiredApplications' => array('Yaga' => '1.0'),
    'MobileFriendly' => true,
    'Author' => 'Bleistivt',
    'AuthorUrl' => 'http://bleistivt.net',
    'License' => 'GNU GPL2'
);

class YagaDisableActivityReactionsPlugin extends Gdn_Plugin {

    public function activityController_initialize_handler($sender) {
        $session = Gdn::session();
        $session->setPermission('Yaga.Reactions.Add', false);

        if ($session->User->Admin) {
            $sender->Head->addString(
                '<style type="text/css">.Item.Activity .Reactions{display:none;}</style>'
            );
        }
    }

    public function ReactionModel_AfterReactionSave_Handler($sender, $args) {
        if ($args['ParentType'] == 'activity'){
            throw permissionException();
        }
    }

}
