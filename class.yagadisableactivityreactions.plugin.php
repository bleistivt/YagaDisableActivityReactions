<?php

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


    public function profileController_initialize_handler($sender) {
        $this->activityController_initialize_handler($sender);
    }


    public function reactionModel_beforeReactionSave_handler($sender, $args) {
        if ($args['ParentType'] == 'activity') {
            throw permissionException();
        }
    }

}
