<?php if (!defined('APPLICATION')) exit();

$PluginInfo['YagaDisableActivityReactions'] = array(
    'Name' => 'Yaga Disable Activity Reactions',
    'Description' => 'Turns off reactions for activities.',
    'Version' => '0.2',
    'RequiredApplications' => array('Yaga' => '1.0'),
    'MobileFriendly' => true,
    'Author' => 'Bleistivt',
    'AuthorUrl' => 'http://bleistivt.net',
    'License' => 'GNU GPL2'
);

class YagaDisableActivityReactionsPlugin extends Gdn_Plugin {

    public function ActivityController_Initialize_Handler($Sender) {
        $Session = Gdn::Session();
        $Session->SetPermission('Yaga.Reactions.Add', false);

        if ($Session->User->Admin && is_object($Sender->Head)) {
            $Sender->Head->AddString(
                '<style type="text/css">.Item.Activity .Reactions{display:none;}</style>'
            );
        }
    }

    public function ReactionModel_AfterReactionSave_Handler($Sender, $Args) {
        if ($Args['ParentType'] != 'activity') return;

        Gdn::SQL()->Delete('Reaction', array(
            'ParentType' => 'activity',
            'ParentID' => $Args['ParentID']
        ), 1);
        Yaga::GivePoints($Args['ParentUserID'], -1 * $Args['Points'], 'Reaction');
    }

}
